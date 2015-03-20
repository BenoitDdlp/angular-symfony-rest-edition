<?php

namespace asre\RestBundle\Handler;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CrudHandler
{
  protected $em;
  protected $container;

  public function __construct(ContainerInterface $container)
  {
    /** @var EntityManagerInterface $em */
    $em = $container->get('doctrine.orm.entity_manager');
    $this->em = $em;
    $this->container = $container;
  }

  /**
   * @param string $entityClassName
   * @param string $id
   *
   * @return mixed Entity
   */
  public function get($entityClassName, $id)
  {
    return $this->em->getRepository($entityClassName)->find($id);
  }

  /**
   * @param string                $entityClassName
   * @param ParamFetcherInterface $paramFetcher
   * @param array                 $routeParams parameters from the route url
   *
   * @return array of Entities
   */
  public function getAll($entityClassName, ParamFetcherInterface $paramFetcher, $routeParams = null)
  {
    $offset = $paramFetcher->get('offset');
    $limit = $paramFetcher->get('limit');
    $order = $paramFetcher->get('order');
    $query = $paramFetcher->get('query');
    $filters = $paramFetcher->get('filters');

    if (!empty($routeParams))
    {
      $filters = null === $filters ? $routeParams : array_merge($filters, $routeParams);
    }

    return $this->container->get("asre.rest.searchservice")->doSearch($entityClassName, $limit, $offset, $query, $order, $filters);
  }

  /**
   * Processes a rest request, meant to be called from a controller.
   *  - get or create entity
   *  - process the received form
   *  - validate action
   *  - call business service (*)
   *  - persist
   *
   *  * : try to call a business service method having the same name as the http method
   *        the business service is conventionally named asre.{entityNme}Service  (i.e. : asre.PersonService->patch($person))
   *
   * @param Request $request
   * @param string  $entityClassName
   * @param string  $formClassName
   * @param String  $method
   * @param String  $id
   *
   * @throws \RuntimeException in case the http method is not mapped
   * @return mixed  id | form validation errors | no content
   */
  public function processForm(Request $request, $entityClassName, $formClassName, $method, $id = null)
  {
    $formData = $request->request->all();
    if ($id === null)
    {
      $entity = new $entityClassName();
      //the entity id must be on the url and not on the entity
      unset($formData['id']);
    }
    else
    {
      $entity = $this->em->getRepository($entityClassName)->find($id);
    }

    $form = $this->container->get("form.factory")->create(new $formClassName(), $entity, array('method' => $method));
    $form->submit($formData, 'PATCH' !== $method);

    $this->validateAction($method, $entity);

    if ($form->isValid())
    {
      $entity = $form->getData();
      $this->callBusinessService($entity, $entityClassName, $method);
      $this->em->persist($entity);
      $this->em->flush($entity);

      //Return an empty string for speed improvement
      //TODO : only post should need at least the id as response?
      if ('POST' == $method)
      {
        return array("id" => $entity->getId());
      }
      else
      {
        return null;
      }
    }

    return array(
      'form' => $form,
    );
  }

  protected function validateAction($method, $entity)
  {
    if (!$entity)
    {
      throw new NotFoundHttpException("entity not found");
    }
    switch ($method)
    {
      case "PUT":
      case "PATCH":
        $right = "EDIT";
        break;
      case "POST":
        $right = "CREATE";
        break;
      case "DELETE":
        $right = "DELETE";
        break;
      default:
        throw new \RuntimeException("[$method] is not allowed!");
    }
    if (!$this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
    {
      throw new UnauthorizedHttpException('Basic realm="Asre"',
        sprintf('You don\'t have the authorization to perform %s on %s',
          $right,
          '#' . $entity->getId()
        )
      );
    }
  }

  /**
   * get the service of the entity conventionally named asre.{entityName}Service
   *
   * @param $entity
   * @param $entityClassName
   * @param $method
   */
  public function callBusinessService($entity, $entityClassName, $method)
  {
    try
    {
      if ($entityService = $this->container->get('asre.' . substr($entityClassName, strrpos($entityClassName, '\\') + 1) . 'Service'))
      {
        if (method_exists($entityService, strtolower($method)))
        {
          $method = strtolower($method);
          $entityService->$method($entity, $entityClassName);
        }
      }
    } catch (ServiceNotFoundException $e)
    {
      //no business service defined, just do nothing
    }
  }

  public function delete($entityClassName, $id)
  {
    $entity = $this->em->getRepository($entityClassName)->find($id);
    $this->validateAction("DELETE", $entity);
    $this->callBusinessService($entity, $entityClassName, 'delete');
    $this->em->remove($entity);
    $this->em->flush($entity);
  }

}

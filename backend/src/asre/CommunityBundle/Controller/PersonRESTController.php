<?php

namespace asre\CommunityBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;


/**
 * Person controller.
 */
class PersonRESTController extends FOSRestController
{


  const ENTITY_CLASSNAME = "asre\\CommunityBundle\\Entity\\Person";
  const FORM_CLASSNAME = "asre\\CommunityBundle\\Form\\PersonType";


  /**
   * Lists all Person entities.
   * @Rest\Get("/persons", name="community_persons_all")
   * @Rest\View(serializerEnableMaxDepthChecks=true, serializerGroups={"list"})
   * @Rest\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing pages.")
   * @Rest\QueryParam(name="limit", requirements="\d+", default="70", description="How many entity to return.")
   * @Rest\QueryParam(name="query", requirements=".{1,64}", nullable=true, description="the query to search.")
   * @Rest\QueryParam(name="order", nullable=true, array=true, description="an array of order.")
   * @Rest\QueryParam(name="filters", nullable=true, array=true, description="an array of filters.")
   */
  public function getPersonsAction(Request $request, ParamFetcherInterface $paramFetcher)
  {
    return $this->get('asre.rest.crudhandler')->getAll(
      $this::ENTITY_CLASSNAME,
      $paramFetcher
    );
  }

  /**
   * @Rest\Get("/persons/{id}", name="community_persons_get")
   * @Rest\View(serializerEnableMaxDepthChecks=true)
   **/
  public function getPersonAction($id)
  {

    return $this->get('asre.rest.crudhandler')->get(
      $this::ENTITY_CLASSNAME,
      $id
    );
  }


  /**
   * Creates a new person from the submitted data.
   *
   * @Rest\Post("/persons",name="community_persons_post")
   *
   * @param Request $request the request object
   *
   * @return array|\FOS\RestBundle\View\View
   */
  public function postPersonAction(Request $request)
  {

    return $this->get('asre.rest.crudhandler')->processForm(
      $request,
      $this::ENTITY_CLASSNAME,
      $this::FORM_CLASSNAME,
      'POST'
    );
  }


  /**
   * Put action
   * @Rest\Put("/persons/{id}", name="community_persons_put")
   *
   * @var Request $request
   * @var integer $id Id of the entity
   * @return mixed
   */
  public function putPersonAction(Request $request, $id)
  {

    return $this->get('asre.rest.crudhandler')->processForm(
      $request,
      $this::ENTITY_CLASSNAME,
      $this::FORM_CLASSNAME,
      'PUT', $id
    );
  }


  /**
   * Patch action
   * @Rest\Patch("/persons/{id}", name="community_persons_patch")
   *
   * @var Request $request
   * @var integer $id Id of the entity
   * @return mixed
   */
  public function patchPersonAction(Request $request, $id)
  {
    return $this->get('asre.rest.crudhandler')->processForm(
      $request,
      $this::ENTITY_CLASSNAME,
      $this::FORM_CLASSNAME,
      'PATCH', $id
    );
  }


  /**
   * Delete action
   * @Rest\Delete("/persons/{id}", name="community_persons_delete")
   *
   * @var integer $id Id of the entity
   */
  public function deletePersonAction($id)
  {

    $this->get('asre.rest.crudhandler')->delete(
      $this::ENTITY_CLASSNAME,
      $id
    );

  }

}
        
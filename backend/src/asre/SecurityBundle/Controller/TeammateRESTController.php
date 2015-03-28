<?php

namespace asre\SecurityBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 */
class TeammateRESTController extends FOSRestController
{

  const ENTITY_CLASSNAME = "asre\\SecurityBundle\\Entity\\Teammate";
  const FORM_CLASSNAME = "asre\\SecurityBundle\\Form\\TeammateType";

  /**
   * Lists all Team entities.
   * @Rest\Get("/teammates",name="asre_security_teammates_all")
   * @Rest\View(serializerEnableMaxDepthChecks=true, serializerGroups={"list"})
   * @Rest\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing pages.")
   * @Rest\QueryParam(name="limit", requirements="\d+", default="10", description="How many entity to return.")
   * @Rest\QueryParam(name="query", requirements=".{1,128}", nullable=true, description="the query to search.")
   * @Rest\QueryParam(name="order", nullable=true, array=true, description="an array of order.")
   * @Rest\QueryParam(name="filters", nullable=true, array=true, description="an array of filters.")
   */
  public function getTeamsAction(Request $request, ParamFetcherInterface $paramFetcher)
  {
    return $this->get('asre.rest.crudhandler')->getAll(
      $this::ENTITY_CLASSNAME,
      $paramFetcher
    );

  }

  /**
   * @Rest\Get("/teammates/{id}",name="asre_security_teammates_get")
   * @Rest\View(serializerEnableMaxDepthChecks=true)
   **/
  public function getTeamAction($id)
  {

    return $this->get('asre.rest.crudhandler')->get(
      $this::ENTITY_CLASSNAME,
      $id
    );
  }


  /**
   * Creates a new Team from the submitted data.
   *
   * @Rest\Post("/teammates",name="asre_security_teammates_post")
   *
   * @param Request $request the request object
   *
   * @return array|\FOS\RestBundle\View\View
   */
  public function postTeamAction(Request $request)
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
   * @Rest\Put("/teammates/{id}",name="asre_security_teammates_put")
   *
   * @var Request $request
   * @var integer $id Id of the entity
   * @return mixed
   */
  public function putTeamAction(Request $request, $id)
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
   * @Rest\Patch("/teammates/{id}",name="asre_security_teammates_patch")
   *
   * @var Request $request
   * @var integer $id Id of the entity
   * @return mixed
   */
  public function patchTeamAction(Request $request, $id)
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
   * @Rest\Delete("/teammates/{id}",name="asre_security_teammates_delete")
   *
   * @var integer $id Id of the entity
   */
  public function deleteTeamAction($id)
  {

    $this->get('asre.rest.crudhandler')->delete(
      $this::ENTITY_CLASSNAME,
      $id
    );
  }

}
<?php

namespace asre\ContentBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;


/**
 * Location rest controller.
 */
class LocationRESTController extends FOSRestController
{

  const ENTITY_CLASSNAME = "asre\\ContentBundle\\Entity\\Location";
  const FORM_CLASSNAME = "asre\\ContentBundle\\Form\\LocationType";

  /**
   * Lists all MainEventLocation entities.
   * @Rest\Get("/locations",name="content_locations_all")
   * @Rest\View(serializerEnableMaxDepthChecks=true, serializerGroups={"list"})
   * @Rest\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing pages.")
   * @Rest\QueryParam(name="limit", requirements="\d+", default="10", description="How many entity to return.")
   * @Rest\QueryParam(name="query", requirements=".{1,128}", nullable=true, description="the query to search.")
   * @Rest\QueryParam(name="order", nullable=true, array=true, description="an array of order.")
   * @Rest\QueryParam(name="filters", nullable=true, array=true, description="an array of filters.")
   */
  public function getLocationsAction(Request $request, ParamFetcherInterface $paramFetcher)
  {
    return $this->get('asre.rest.crudhandler')->getAll(
      $this::ENTITY_CLASSNAME,
      $paramFetcher
    );
  }

  /**
   * @Rest\Get("/locations/{id}",name="content_locations_get")
   * @Rest\View(serializerEnableMaxDepthChecks=true)
   **/
  public function getLocationAction($id)
  {

    return $this->get('asre.rest.crudhandler')->get(
      $this::ENTITY_CLASSNAME,
      $id
    );
  }


  /**
   * Creates a new MainEventLocation from the submitted data.
   *
   * @Rest\Post("/locations",name="content_locations_post")
   *
   * @param Request $request the request object
   *
   * @return array|\FOS\RestBundle\View\View
   */
  public function postLocationAction(Request $request)
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
   * @Rest\Put("/locations/{id}",name="content_locations_put")
   *
   * @var Request $request
   * @var integer $id Id of the entity
   * @return mixed
   */
  public function putLocationAction(Request $request, $id)
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
   * @Rest\Patch("/locations/{id}",name="content_locations_patch")
   *
   * @var Request $request
   * @var integer $id Id of the entity
   * @return mixed
   */
  public function patchLocationAction(Request $request, $id)
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
   * @Rest\Delete("/locations/{id}",name="content_locations_delete")
   *
   * @var integer $id Id of the entity
   */
  public function deleteLocationAction($id)
  {

    $this->get('asre.rest.crudhandler')->delete(
      $this::ENTITY_CLASSNAME,
      $id
    );
  }

}
        
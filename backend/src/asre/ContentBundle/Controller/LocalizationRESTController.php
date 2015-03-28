<?php

namespace asre\ContentBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;


/**
 * Localization rest controller.
 */
class LocalizationRESTController extends FOSRestController
{

  const ENTITY_CLASSNAME = "asre\\ContentBundle\\Entity\\Localization";
  const FORM_CLASSNAME = "asre\\ContentBundle\\Form\\LocalizationType";


  /**
   * Lists all localizations entities.
   * @Rest\Get("/localizations",name="asre_asre_content_localizations_all")
   * @Rest\View(serializerEnableMaxDepthChecks=true, serializerGroups={"list"})
   * @Rest\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing pages.")
   * @Rest\QueryParam(name="limit", requirements="\d+", default="10", description="How many entity to return.")
   * @Rest\QueryParam(name="query", requirements=".{1,128}", nullable=true, description="the query to search.")
   * @Rest\QueryParam(name="order", nullable=true, array=true, description="an array of order.")
   * @Rest\QueryParam(name="filters", nullable=true, array=true, description="an array of filters.")
   */
  public function getLocalizationsAction(Request $request, ParamFetcherInterface $paramFetcher)
  {
    return $this->get('asre.rest.crudhandler')->getAll(
      $this::ENTITY_CLASSNAME,
      $paramFetcher
    );

  }

  /**
   * @Rest\Get("/localizations/{id}",name="asre_content_localizations_get")
   * @Rest\View(serializerEnableMaxDepthChecks=true)
   **/
  public function getLocalizationsByIdAction($id)
  {

    return $this->get('asre.rest.crudhandler')->get(
      $this::ENTITY_CLASSNAME,
      $id
    );
  }


  /**
   * Creates a new Localizations from the submitted data.
   *
   * @Rest\Post("/localizations",name="asre_content_localizations_post")
   *
   * @param Request $request the request object
   *
   * @return array|\FOS\RestBundle\View\View
   */
  public function postLocalizationsAction(Request $request)
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
   * @Rest\Put("/localizations/{id}",name="asre_content_localizations_put")
   *
   * @var Request $request
   * @var integer $id Id of the entity
   * @return mixed
   */
  public function putLocalizationsAction(Request $request, $id)
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
   * @Rest\Patch("/localizations/{id}",name="asre_content_localizations_patch")
   *
   * @var Request $request
   * @var integer $id Id of the entity
   * @return mixed
   */
  public function patchLocalizationsAction(Request $request, $id)
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
   * @Rest\Delete("/localizations/{id}",name="asre_content_localizations_delete")
   *
   * @var integer $id Id of the entity
   */
  public function deleteLocalizationsAction($id)
  {

    $this->get('asre.rest.crudhandler')->delete(
      $this::ENTITY_CLASSNAME,
      $id
    );
  }

}
        
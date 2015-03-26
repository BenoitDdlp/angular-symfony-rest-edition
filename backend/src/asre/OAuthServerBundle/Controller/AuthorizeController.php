<?php
/**
 *
 * @author benoitddlp
 */

namespace asre\OAuthServerBundle\Controller;

use asre\OAuthServerBundle\Entity\Client;
use asre\OAuthServerBundle\Form\Model\Authorize;
use FOS\OAuthServerBundle\Form\Handler\AuthorizeFormHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\OAuthServerBundle\Controller\AuthorizeController as BaseAuthorizeController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthorizeController extends BaseAuthorizeController
{
  /**
   * @Template(template="OAuthServerBundle:Authorize:authorize.html.twig")
   *
   * @param Request $request
   *
   * @return mixed
   */
  public function authorizeAction(Request $request)
  {
    if (!$request->get('client_id'))
    {
      throw new NotFoundHttpException("Client id parameter {$request->get('client_id')} is missing.");
    }

    $clientManager = $this->container->get('fos_oauth_server.client_manager.default');
    $client = $clientManager->findClientByPublicId($request->get('client_id'));

    if (!($client instanceof Client))
    {
      throw new NotFoundHttpException("Client {$request->get('client_id')} is not found.");
    }

    $user = $this->container->get('security.context')->getToken()->getUser();

    $form = $this->container->get('asre_oauth_server.authorize.form');
    $formHandler = $this->container->get('asre_oauth_server.authorize.form_handler');

    $authorize = new Authorize();

    if (false !== ($response = $formHandler->process($authorize)))
    {
      return $response;
    }

    return array(
      'form'   => $form->createView(),
      'client' => $client,
    );
  }
}
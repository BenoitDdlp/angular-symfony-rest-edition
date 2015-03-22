<?php

namespace asre\OAuthServerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Override edit and show action of FOS\UserBundle\Controller\ProfileController
 */
class OAuthSecurityController extends Controller
{
  /**
   * set user Id in the session so we can get it back next to his social account loggin
   * @Route("/oauth/v2/auth_login", name="asre_oauth_server_auth_login")
   *
   * @Template
   *
   * @param Request $request
   *
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function loginAction(Request $request)
  {
    $session = $request->getSession();

    if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
    {
      $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
    }
    elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR))
    {
      $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
      $session->remove(SecurityContext::AUTHENTICATION_ERROR);
    }
    else
    {
      $error = '';
    }

    if ($error)
    {
      $error = $error->getMessage(); // WARNING! Symfony source code identifies this line as a potential security threat.
    }

    $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

    return array(
      'last_username' => $lastUsername,
      'error'         => $error,
    );
  }

  /**
   * set user Id in the session so we can get it back next to his social account loggin
   * @Route("/oauth/v2/auth_login_check", name="asre_oauth_server_auth_login_check")
   */
  public function loginCheckAction(Request $request)
  {
    \Doctrine\Common\Util\Debug::dump($request->request);
  }
}

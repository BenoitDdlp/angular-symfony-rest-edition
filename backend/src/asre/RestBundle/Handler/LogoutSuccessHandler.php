<?php

namespace asre\RestBundle\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;


class LogoutSuccessHandler implements LogoutSuccessHandlerInterface
{

  /**
   * Creates a Response object to send upon a successful logout.
   *
   * @param Request $request
   *
   * @return Response never null
   */
  public function onLogoutSuccess(Request $request)
  {
    $response = new Response();
    $response->headers->set('Content-Type', 'application/json');

    return $response;
  }
}
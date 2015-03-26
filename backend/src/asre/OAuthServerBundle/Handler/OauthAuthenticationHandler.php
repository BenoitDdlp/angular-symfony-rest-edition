<?php

namespace asre\OAuthServerBundle\Handler;

use FOS\OAuthServerBundle\Model\AuthCodeManagerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use JMS\Serializer\SerializerInterface;
use OAuth2\Model\IOAuth2Token;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Translation\TranslatorInterface;


class OauthAuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{

  protected $router;
  protected $userManager;
  protected $authCodeManagerInterface;
  protected $translator;

  public function __construct(RouterInterface $router, UserManagerInterface $userManager, AuthCodeManagerInterface $authCodeManagerInterface, TranslatorInterface $translator, SerializerInterface $jms_serializer)
  {
    $this->router = $router;
    $this->userManager = $userManager;
    $this->authCodeManagerInterface = $authCodeManagerInterface;
    $this->translator = $translator;
    $this->jms_serializer = $jms_serializer;
  }

  /**
   * onAuthenticationSuccess
   * if html asked :
   *  Redirect to the front end at :
   *    - the profile page in case the password hasn't been set yet
   *    - otherwise to the homepage
   * else:
   *  return the json user
   *
   * @param Request        $request
   * @param TokenInterface $token
   *
   * @return RedirectResponse|Response
   */
  public function onAuthenticationSuccess(Request $request, TokenInterface $token)
  {
    /** @var \asre\SecurityBundle\Entity\User $user */
    $user = $token->getUser();
    $user->setLastLogin(new \DateTime());
    $this->userManager->updateUser($user);
    if ('html' == $request->getRequestFormat())
    {
      return new RedirectResponse($this->router->generate('asre_frontend_front_index'));
    }
    else
    {
//      $serializationCtx = (new SerializationContext())->enableMaxDepthChecks(true);
//      $responseArr = $this->jms_serializer->serialize($user, 'json', $serializationCtx);
//      $this->authCodeManagerInterface->deleteExpired();
      /** @var IOAuth2Token $oauthCode */
      $oauthCode = $this->authCodeManagerInterface->findAuthCodeBy(array("user" => $user->getId()));
      $response = new Response(json_encode(array("code" => $oauthCode->getToken())));
      $response->headers->set('Content-Type', 'application/json');
    }

    return $response;
  }

  public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
  {
    $result = array(
      'error' => $this->translator->trans($exception->getMessage(), array(), 'FOSUserBundle'),
    );
    $response = new Response(json_encode($result), 400);
    $response->headers->set('Content-Type', 'application/json');

    return $response;
  }
}
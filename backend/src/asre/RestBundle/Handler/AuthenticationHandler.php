<?php

namespace asre\RestBundle\Handler;

use FOS\OAuthServerBundle\Model\AuthCodeInterface;
use FOS\OAuthServerBundle\Model\AuthCodeManagerInterface;
use FOS\OAuthServerBundle\Model\ClientManagerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use OAuth2\IOAuth2GrantCode;
use OAuth2\OAuth2;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Translation\TranslatorInterface;


class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{

  protected $router;
  protected $security;
  protected $userManager;
  protected $translator;
  protected $jms_serializer;
  protected $oauth2;
  protected $authCodeManager;
  protected $clientManager;
  protected $storage;
  protected $oAuthClientId;
  protected $oAuthSecret;
  protected $frontEndPath;

  public function __construct(RouterInterface $router, SecurityContext $security, UserManagerInterface $userManager, TranslatorInterface $translator, SerializerInterface $jms_serializer, OAuth2 $oauth2, AuthCodeManagerInterface $authCodeManager, ClientManagerInterface $clientManager, IOAuth2GrantCode $storage, $oAuthClientId, $oAuthSecret, $frontEndPath)
  {
    $this->router = $router;
    $this->security = $security;
    $this->userManager = $userManager;
    $this->translator = $translator;
    $this->jms_serializer = $jms_serializer;
    $this->oauth2 = $oauth2;
    $this->authCodeManager = $authCodeManager;
    $this->clientManager = $clientManager;
    $this->storage = $storage;
    $this->oAuthClientId = $oAuthClientId;
    $this->oAuthSecret = $oAuthSecret;
    $this->frontEndPath = $frontEndPath;
  }

  /**
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

    //create a auth code copying the one received by the social service oauth2 endpoint
    /** @var AuthCodeInterface $authCode */
    $authCode = $this->storage->createAuthCode(
      $request->query->get('code'),
      $this->clientManager->findClientByPublicId($this->oAuthClientId),
      $user,
      $this->frontEndPath,
      time() + OAuth2::DEFAULT_AUTH_CODE_LIFETIME
    );


    $redirectUrl = $this->router->generate('asre_frontend_front_index');

    if ($user->isRandomPwd())
    {
      $redirectUrl .= '#code=' . $authCode->getToken();
    }
    //this redirection should prompt the user to change his password
    $response = new RedirectResponse($redirectUrl);

//    $redirectUrl = $this->router->generate('fos_oauth_server_token');
//    $response = new RedirectResponse(
//      sprintf($redirectUrl . "?client_id=%s&client_secret=%s&grant_type=%s&redirect_uri=%s&code=%s",
//        $this->oAuthClientId,
//        $this->oAuthSecret,
//        "authorization_code",
//        $this->frontEndPath,
//        $request->query->get('code')
//      ));
    return $response;

//    token?
//      client_id=6_1qw5cxiattogs8ckgk8cw00cwo0kk0wsckc0c0kcssg0o8csok
//    &client_secret=1v1rd14maydc8sc88wco400k4s4k0kgwwk484gsk8w4ggwcgsg
//  &grant_type=authorization_code
//  &redirect_uri=http://192.168.0.13/asre/frontend/app/&code=OGFhYTc1NjNiOTM3NDg3ZGVjZjM2YmMyYjIxMTcxZTA4YmU0MGFmYTcyZTYxYjgyNWI2NDg5ZWY3ZjZhMzc3Mg

    if ('html' == $request->getRequestFormat())
    {
      $redirectUrl = $this->router->generate('asre_frontend_front_index');

      if ($user->isRandomPwd())
      {
        $redirectUrl .= '#/profile';
      }
      //this redirection should prompt the user to change his password
      $response = new RedirectResponse($redirectUrl);
    }
    else
    {
//      $user->setRememberMeToken($request->cookies->get('REMEMBERME'));
      $serializationCtx = (new SerializationContext())->enableMaxDepthChecks(true);
      $responseArr = $this->jms_serializer->serialize($user, 'json', $serializationCtx);

      $response = new Response($responseArr);
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
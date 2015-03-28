<?php
/**
 *
 * @author benoitddlp
 */
namespace asre\SecurityBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;

/**
 * Class UserRESTController
 *
 * @package asre\SecurityBundle\REST\Controller
 */
class UserRESTController extends Controller
{
  /**********************************   signup & confirm  ***********************************************/

  /**
   * handle the signup form and sends a confirmation mail.
   * @Route("/signup", name="asre_security_signup")
   */
  public function signupAction(Request $request)
  {

    /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
    $formFactory = $this->container->get('fos_user.registration.form.factory');
    /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
    $userManager = $this->container->get('fos_user.user_manager');
    /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
    $dispatcher = $this->container->get('event_dispatcher');

    $user = $userManager->createUser();
    $user->setEnabled(true);

    $event = new GetResponseUserEvent($user, $request);
    $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

    if (null !== $event->getResponse())
    {
      return $event->getResponse();
    }

    $form = $formFactory->createForm();
    $form->setData($user);

    $form->submit($request);

    if ($form->isValid())
    {
      $event = new FormEvent($form, $request);
      $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

      $this->container->get('asre.UserService')->post($user);
      $userManager->updateUser($user);

      $successResponse = new Response('Register_success');

      //confirmation not enabled
      if (null === $response = $event->getResponse())
      {
        $this->authenticateUser($user, $successResponse);
      }
      else
      {
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
      }

      return $successResponse;
    }

    //investigate on failure...
    $result = array(
      'message' => 'Validation Failed',
      'errors'  => array('errors' => array()),
    );

    if (null != $userManager->findUserByUsername($form->getData()->getUsername()))
    {
      $result['errors']['errors'][] = "{'field' : 'username', 'msg' : 'authentication.validations.signup_username_in_use'}";
    }

    if (null != $userManager->findUserByEmail($form->getData()->getEmail()))
    {
      $result['errors']['errors'][] = "{'field' : 'email', 'msg' : 'authentication.validations.signup_email_in_use'}";
    }

    if (count($result['errors']['errors']) > 0)
    {
      $response = new Response(json_encode($result), 400);
      $response->headers->set('Content-Type', 'application/json');

      return $response;
    }

    throw new \Exception('Register_error');

  }

  /**
   * Authenticate a user with Symfony Security
   *
   * @param \FOS\UserBundle\Model\UserInterface        $user
   * @param \Symfony\Component\HttpFoundation\Response $response
   */
  protected function authenticateUser(UserInterface $user, Response $response)
  {
    try
    {
      $this->container->get('fos_user.security.login_manager')->loginUser(
        $this->container->getParameter('fos_user.firewall_name'),
        $user,
        $response);
    } catch (AccountStatusException $ex)
    {
      // We simply do not authenticate users which do not pass the user
      // checker (not enabled, expired, etc.).
    }
  }




  /**********************************   change & reset password  ***********************************************/

  /**
   * validate confirm link sent by mail
   *  => Redirect to the frontend confirmation page.
   * @Rest\Get("/confirm", name="fos_user_registration_confirm")fos_user_registration_check_email
   * @Rest\QueryParam(name="token", requirements=".{32,64}", description="The confirmation token from user email provider.")
   */
  public function confirmRedirectAction(Request $request, ParamFetcherInterface $paramFetcher)
  {
    $token = $paramFetcher->get('token');

    return $this->redirect($this->container->getParameter('front_end_path') . '#/confirm/' . $token);
  }

  /**
   * Receive the confirmation token from the front end
   *  => authenticate the user and prompt him to change his password
   * @Rest\Post("/user/confirm", name="asre_security_confirm")
   * @Rest\View(serializerEnableMaxDepthChecks=true)
   */
  public function confirmAction(Request $request)
  {
    $token = $request->request->get('token');
    $userManager = $this->container->get('fos_user.user_manager');
    /** @var \asre\SecurityBundle\Entity\User $user */
    $user = $userManager->findUserByConfirmationToken($token);

    if (null === $user || strlen($token) == 0)
    {
      throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
    }
    //let the user a way to login if he doesn't change his password
    if (!$user->isRandomPwd())
    {
      $user->setConfirmationToken(null);
    }

//        $aclHelper = $this->container->get('asre_security.acl_user_permission_helper');
//        $aclHelper->performUpdateUserACL($user, MaskBuilder::MASK_OWNER, $user->getPerson());
//        if (null != $invitor = $user->getPerson()->getInvitedBy())
//        {
//            $aclHelper->performDeleteUserACL($invitor->getUser(), $user->getPerson());
//        }
    $user->setEnabled(true);
    $user->setLastLogin(new \DateTime());
    $userManager->updateUser($user);

    $response = new Response($this->container->get('jms_serializer')->serialize($user, $request->getRequestFormat()));
    $response->headers->set('Content-Type', 'application/json');
    $this->authenticateUser($user, $response);

    return $response;
  }

  /**
   * change the password of an user.
   * If the password is still random, don't ask for it.
   * @Route("/user/change_pwd", name="asre_security_changepwd")
   */
  public function changePwdAction(Request $request)
  {
    /** @var \asre\SecurityBundle\Entity\User $user */
    $user = $this->getUser();
    if (!is_object($user) || !$user instanceof UserInterface)
    {
      throw new AccessDeniedException('This user does not have access to this section.');
    }

    //TODO : find a better way to do this ?
    $changePasswordForm = json_decode($request->getContent(), true);
    if ($changePasswordForm['new_password_first'] !== $changePasswordForm['new_password_second'])
    {
      throw new \Exception('Changepwd_mismatch_error');
    }
    $newPassword = $changePasswordForm['new_password_first'];

    if (!$user->isRandomPwd())
    {
      $oldPassword = $changePasswordForm['current_password'];
      if ($oldPassword === $newPassword)
      {
        throw new \Exception('Changepwd_nochange_error');
      }
      $encoder = $this->get('security.encoder_factory')->getEncoder($user);
      $passwordSecure = $encoder->encodePassword($oldPassword, $user->getSalt());
      if ($passwordSecure !== $user->getPassword())
      {
        throw new \Exception('Changepwd_currentpwd_error');
      }
    }

    $userManager = $this->container->get('fos_user.user_manager');
    $user->setPlainPassword($newPassword);
    $user->setRandomPwd(false);
    $user->setConfirmationToken(null);
    $userManager->updateUser($user);

    $response = new Response($this->container->get('jms_serializer')->serialize($user, $request->getRequestFormat()));
    $response->headers->set('Content-Type', 'application/json');
    $this->authenticateUser($user, $response);

    return $response;
  }

  /**
   * Send the reset mail
   * @Rest\Post("/reset_pwd_request", name="asre_community_organizations_")
   */
  public function resetPwdRequestAction(Request $request)
  {
    $username = $request->request->get('username');

    /** @var $user UserInterface */
    $user = $this->container->get('fos_user.user_manager')->findUserByUsernameOrEmail($username);

    if (null === $user)
    {
      throw new NotFoundHttpException('Resetpwd_usernotfound_error');
    }

//    if ($user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
//      throw new \Exception('Resetpwd_pwdalreadyrequested_error');
//    }

    if (null === $user->getConfirmationToken())
    {
      /** @var $tokenGenerator \FOS\UserBundle\Util\TokenGeneratorInterface */
      $tokenGenerator = $this->container->get('fos_user.util.token_generator');
      $user->setConfirmationToken($tokenGenerator->generateToken());
    }

    $this->container->get('fos_user.mailer')->sendResettingEmailMessage($user);
    $user->setPasswordRequestedAt(new \DateTime());
    $this->container->get('fos_user.user_manager')->updateUser($user);

    return new Response('', 204); //No Content
  }





  /**********************************   utils  ***********************************************/

  /**
   * Redirect to the frontend reset password page.
   * @Rest\Get("/reset_pwd", name="fos_user_resetting_reset")
   * @Rest\QueryParam(name="token", requirements=".{32,64}", description="The confirmation token from user email provider.")
   */
  public function confirmResetPwdAction(Request $request, ParamFetcherInterface $paramFetcher)
  {
    $token = $paramFetcher->get('token');

    return $this->redirect($this->container->getParameter('front_end_path') . '#/reset/' . $token);
  }

  /**
   * Redirect to the frontend api confirmation page.
   * @Rest\Post("/reset_pwd", name="asre_security_resetpwd")
   * @Rest\View(serializerEnableMaxDepthChecks=true, serializerGroups={"list"})
   */
  public function resetAction(Request $request)
  {
    $token = $request->request->get('token');
    /** @var \asre\SecurityBundle\Entity\User $user */
    $user = $this->container->get('fos_user.user_manager')->findUserByConfirmationToken($token);

    if (null === $user || strlen($token) == 0)
    {
      throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
    }

    if (!$user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl')))
    {
      throw new \Exception('Resetpwd_pwdresetexpired_error');
    }

    $userManager = $this->container->get('fos_user.user_manager');
    $user->setConfirmationToken(null);
    $user->setPasswordRequestedAt(null);
    $user->setEnabled(true);
    $user->setRandomPwd(true);
    $userManager->updateUser($user);

    $response = new Response($this->container->get('jms_serializer')->serialize($user, $request->getRequestFormat()));
    $response->headers->set('Content-Type', 'application/json');
    $this->authenticateUser($user, $response);

    return $response;
  }
}
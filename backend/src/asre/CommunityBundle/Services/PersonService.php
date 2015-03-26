<?php

namespace asre\CommunityBundle\Services;

use asre\CommunityBundle\Entity\Person;
use asre\RestBundle\Services\AbstractBusinessService;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class PersonService
 *
 * @package asre\EventBundle\Services
 */
class PersonService extends AbstractBusinessService
{
  protected $securityContext;
  protected $userManager;
  protected $tokenGenerator;
  protected $mailer;
  protected $session;

  public function __construct(SecurityContextInterface $securityContext, UserManagerInterface $userManager, TokenGeneratorInterface $tokenGenerator, MailManager $mailer)
  {
    $this->securityContext = $securityContext;
    $this->userManager = $userManager;
    $this->tokenGenerator = $tokenGenerator;
    $this->mailer = $mailer;
  }

  /**
   * invite a person
   * - create an user linked to the person
   * - send a confirmation mail enabling it to log afterward
   * - add the current logged user as "godfather"
   *
   * @param Person $person
   *
   * @throws \Doctrine\DBAL\DBALException when email or username is already in use
   */
  public function post(Person $person)
  {

    /** @var \asre\SecurityBundle\Entity\User $newUser */
    $newUser = $this->userManager->createUser();
    $person->setUser($newUser);


    $email = $person->getEmail();
    $newUser->setUsername($email);
    $newUser->setEmail($email);

    $randomPwd = substr(base_convert(bin2hex(hash('sha256', uniqid(mt_rand(), true), true)), 16, 36), 0, 12);
    $newUser->setPlainPassword($randomPwd);
    $newUser->setRandomPwd(true);
    $newUser->setEnabled(false);
    $newUser->setConfirmationToken($this->tokenGenerator->generateToken());

    $this->userManager->updateUser($newUser);

    $user = $this->getLoggedUser();
    if ($user->getId() != $newUser->getId())
    {
      //add the current logged user as "godfather"
      $person->setInvitedBy($user->getPerson());
    }

    $this->mailer->sendConfirmationEmailMessage($newUser);
  }

  protected function getLoggedUser()
  {
    return $this->securityContext->getToken()->getUser();
  }

  /**
   * validate edit ction
   *
   * @param Person $person
   *
   * @throws \Doctrine\DBAL\DBALException when email or username is already in use
   * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
   */
  public function put(Person $person)
  {
    $this->validateAction($person);
  }

  protected function validateAction(Person $person)
  {
    if (null == $person->getUser())
    {
      throw new AccessDeniedException('Not your account!');
    }

    $currentUser = $this->getLoggedUser();
    if ($currentUser->getId() != $person->getUser()->getId())
    {
      throw new AccessDeniedException('Not your account!');
    }

    return $currentUser;
  }

  /**
   * validate edit action
   *
   * @param Person $person
   *
   * @throws \Doctrine\DBAL\DBALException when email or username is already in use
   * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
   */
  public function patch(Person $person)
  {
    $this->validateAction($person);
  }

  /**
   * if the account isn't activated, send a new mail
   *
   * @param Person $person
   *
   * @throws \Doctrine\DBAL\DBALException when email or username is already in use
   * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
   */
  public function delete(Person $person)
  {
    $user = $this->validateAction($person);
    $user->setPerson(null);
    $person->setUser(null);
    $this->userManager->deleteUser($user);
    //delete person ??
  }
}
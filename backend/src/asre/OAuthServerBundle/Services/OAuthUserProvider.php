<?php
/**
 *
 * @author benoitddlp
 */

namespace asre\OAuthServerBundle\Services;

use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class OAuthUserProvider implements UserProviderInterface
{
  /**
   * @var UserManagerInterface
   */
  protected $userManager;

  public function __construct(UserManagerInterface $userManager)
  {
    $this->userManager = $userManager;
  }

  public function loadUserByUsername($username)
  {
    return $this->userManager->findUserByUsernameOrEmail($username);
  }

  public function refreshUser(UserInterface $user)
  {
    echo "\asre\OAuthServerBundle\Services\OAuthUserProvider::refreshUser";
    die;
    $class = get_class($user);
    if (!$this->supportsClass($class))
    {
      throw new UnsupportedUserException(
        sprintf(
          'Instances of "%s" are not supported.',
          $class
        )
      );
    }

    return $this->userRepository->find($user->getId());
  }

  public function supportsClass($class)
  {
    return $this->userRepository->getClassName() === $class
    || is_subclass_of($class, $this->userRepository->getClassName());
  }
}
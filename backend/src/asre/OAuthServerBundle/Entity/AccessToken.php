<?php
/**
 *
 * @author benoitddlp
 */

namespace asre\OAuthServerBundle\Entity;

use FOS\OAuthServerBundle\Entity\AccessToken as BaseAccessToken;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AccessToken extends BaseAccessToken
{
  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ORM\ManyToOne(targetEntity="Client")
   * @ORM\JoinColumn(nullable=false)
   */
  protected $client;

  /**
   * @ORM\ManyToOne(targetEntity="asre\SecurityBundle\Entity\User")
   */
  protected $user;
}
<?php
/**
 *
 * @author benoitddlp
 */

namespace asre\OAuthServerBundle\Entity;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Client extends BaseClient
{
  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;
  /**
   * @ORM\Column
   */
  protected $name;

  /**
   * @return String
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * @param String $name
   */
  public function setName($name)
  {
    $this->name = $name;
  }
}
<?php
/**
 *
 * @author benoitddlp
 */

namespace asre\OAuthServerBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;


class Authorize
{
  /**
   * @Assert\True(
   *      message = "Please check the checkbox to allow access to your profile."
   * )
   **/
  protected $allowAccess;

  /**
   * @return boolean
   */
  public function getAllowAccess()
  {
    return $this->allowAccess;
  }

  /**
   * @param boolean $allowAccess
   */
  public function setAllowAccess($allowAccess)
  {
    $this->allowAccess = $allowAccess;
  }
}
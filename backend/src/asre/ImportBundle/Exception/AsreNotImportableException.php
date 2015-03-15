<?php
namespace asre\ImportBundle\Exception;

/**
 *
 * @author benoitddlp
 */
class AsreNotImportableException extends \RunTimeException
{
  /**
   * @param string $msg
   */
  public function __construct($msg)
  {
    parent::__construct($msg);
  }
}

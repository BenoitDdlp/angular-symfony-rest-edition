<?php
namespace asre\ImportBundle\Services;

/**
 * util class ImportHelper
 * Class ImportHelper
 * contains the list to
 *
 * @package asre\ImportBundle\Services
 */
class ImportHelper
{
  public static $entityConfig = array(
    'Event'    => array(
      'classpath' => 'asre\\EventBundle\\Entity',
    ),
    'Location' => array(
      'classpath' => 'asre\\ContentBundle\\Entity',
    ),
    'Paper'    => array(
      'classpath' => 'asre\\ContentBundle\\Entity',
    ),
    'Person'   => array(
      'classpath' => 'asre\\CommunityBundle\\Entity',
    ),
    'Role'     => array(
      'classpath' => 'asre\\ContentBundle\\Entity',
    ),
  );

  static function getClassNameFromShortClassName($shortClassName)
  {
    if (isset(self::$entityConfig[$shortClassName]))
    {
      return self::$entityConfig[$shortClassName]["classpath"] . "\\" . $shortClassName;
    }
    throw new \Exception("'$shortClassName' is not configured to be imported");
  }
}
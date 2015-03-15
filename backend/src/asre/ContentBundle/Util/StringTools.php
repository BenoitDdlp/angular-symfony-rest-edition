<?php

/**
 *
 * @author :  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace asre\ContentBundle\Util;

class StringTools
{
  /**
   * Modifies a string to remove all non ASCII characters and spaces
   *
   * @param string $text
   * @param bool   $lowerCase
   *
   * @return string
   */
  static public function slugify($text, $lowerCase = true)
  {
    // replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
    // trim
    $text = trim($text, '-');
    // transliterate
    if (function_exists('iconv'))
    {
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    }
    // lowercase
    if ($lowerCase)
    {
      $text = strtolower($text);
    }
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    if (empty($text))
    {
      return 'n-a';
    }

    return $text;
  }
}

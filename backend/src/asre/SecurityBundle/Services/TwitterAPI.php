<?php

namespace asre\SecurityBundle\Services;

use Buzz\Browser;
use Endroid\Twitter\Twitter;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * @author Benoit ddlp @see FOS\UserBundle\Mailer\Mailer.php
 */
class TwitterAPI extends ContainerAware
{
  /**
   * @var string
   */
  protected $apiUrl = 'https://api.twitter.com/1.1/';

  /**
   * @var string
   */
  protected $consumerKey;

  /**
   * @var string
   */
  protected $consumerSecret;

  /**
   * @var string
   */
  protected $accessToken;

  /**
   * @var string
   */
  protected $accessTokenSecret;

  public function __construct($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret, $apiUrl = null, $curlClient)
  {
    $this->consumerKey = $consumerKey;
    $this->consumerSecret = $consumerSecret;
    $this->accessToken = $accessToken;
    $this->accessTokenSecret = $accessTokenSecret;

    if ($apiUrl)
    {
      $this->apiUrl = $apiUrl;
    }
    $client = $curlClient;
    $this->browser = new Browser($client);
  }

  public function setUser($user)
  {
    if ($user)
    {
      $this->setAccessToken($user->getTwitterAccessToken());
    }
    // $twitter->setAccessToken("2566837897-7BQDoyNx2OV0I8lFfMkzQfkeF6ZbuC0N8ekHoD6");
    // $twitter->setAccessTokenSecret("WPON6RSScVrc6riEuHE96al7NUI8QVDENli4N3ICBkUfM");
  }


  public function setAccessToken($accessToken)
  {
    $this->accessToken = $accessToken;
  }

  public function setAccessTokenSecret($accessTokenSecret)
  {
    $this->accessTokenSecret = $accessTokenSecret;
  }

  /**
   * Returns the user timeline.
   *
   * @param $parameters
   *
   * @return mixed
   */
  public function getTimeline($parameters)
  {
    $response = $this->query('statuses/user_timeline', 'GET', 'json', $parameters);

    return json_decode($response->getContent());
  }

  /**
   * Performs a query to the Twitter API.
   *
   * @param        $name
   * @param string $method
   * @param string $format
   * @param array  $parameters
   *
   * @return \Buzz\Message\Response
   */
  public function query($name, $method = 'GET', $format = 'json', $parameters = array())
  {
    $oauthParameters = array(
      'oauth_consumer_key'     => $this->consumerKey,
      'oauth_nonce'            => time(),
      'oauth_signature_method' => 'HMAC-SHA1',
      'oauth_timestamp'        => time(),
      'oauth_token'            => $this->accessToken,
      'oauth_version'          => '1.0'
    );

    // Part 1 : http method
    $httpMethod = $method;

    // Part 2 : base url
    $baseUrl = $this->apiUrl . $name . '.' . $format;

    // Part 3 : parameter string
    $oauthParameters = array_merge($oauthParameters, $parameters);
    ksort($oauthParameters);
    $parameterQueryParts = array();
    foreach ($oauthParameters as $key => $value)
    {
      $parameterQueryParts[] = $key . '=' . rawurlencode($value);
    }
    $parameterString = implode('&', $parameterQueryParts);

    // Build signature string from part 1, 2 and 3
    $signatureString = strtoupper($httpMethod) . '&' . rawurlencode($baseUrl) . '&' . rawurlencode($parameterString);
    $signatureKey = rawurlencode($this->consumerSecret) . '&' . rawurlencode($this->accessTokenSecret);
    $signature = base64_encode(hash_hmac('sha1', $signatureString, $signatureKey, true));

    // Create headers containing oauth
    $parameterQueryParts[] = 'oauth_signature=' . rawurlencode($signature);
    $oauthHeader = 'OAuth ' . implode(', ', $parameterQueryParts);
    $headers = array(
      'Content-Type: application/x-www-form-urlencoded',
      'Authorization: ' . $oauthHeader
    );

    // The call has to be made against the base url + query string
    if (count($parameters) > 0)
    {
      $requestQueryParts = array();
      foreach ($parameters as $key => $value)
      {
        $requestQueryParts[] = $key . '=' . rawurlencode($value);
      }
      $baseUrl .= '?' . implode('&', $requestQueryParts);
    }

    // Perform cURL request
    if (strtoupper($method) == 'GET')
    {
      $response = $this->browser->get($baseUrl, $headers);
    }
    else
    {
      $response = $this->browser->post($baseUrl, $headers);
    }

    return $response;
  }
}
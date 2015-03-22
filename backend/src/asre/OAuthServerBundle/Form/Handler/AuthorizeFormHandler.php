<?php
/**
 *
 * @author benoitddlp
 */

namespace asre\OAuthServerBundle\Form\Handler;

use asre\OAuthServerBundle\Form\Model\Authorize;
use OAuth2\OAuth2;
use OAuth2\OAuth2ServerException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

class AuthorizeFormHandler
{
  protected $request;
  protected $form;
  protected $context;
  protected $oauth2;

  public function __construct(FormInterface $form, Request $request, SecurityContextInterface $context, OAuth2 $oauth2)
  {
    $this->form = $form;
    $this->request = $request;
    $this->context = $context;
    $this->oauth2 = $oauth2;
  }

  public function process(Authorize $authorize)
  {
    $this->form->setData($authorize);

    if ($this->request->getMethod() == 'POST')
    {

      $this->form->handleRequest($this->request);

      if ($this->form->isValid())
      {

        try
        {
          $user = $this->context->getToken()->getUser();

          return $this->oauth2->finishClientAuthorization(true, $user, $this->request, null);
        } catch (OAuth2ServerException $e)
        {
          return $e->getHttpResponse();
        }

      }

    }

    return false;
  }

}
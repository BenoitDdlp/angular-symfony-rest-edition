<?php
namespace asre\RestBundle\Controller;

/**
 *
 * @author benoitddlp
 */

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RedirectToFrontEndController extends Controller
{
  /**
   * @Route("/", name="asre_frontend_front_index")
   */
  public function indexAction(Request $request)
  {
    return $this->redirect($this->container->getParameter('front_end_path'));
  }
}

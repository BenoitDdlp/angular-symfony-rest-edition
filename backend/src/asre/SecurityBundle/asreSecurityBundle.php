<?php

namespace asre\SecurityBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;


class asreSecurityBundle extends Bundle
{
  public function getParent()
  {
    return 'FOSUserBundle';
  }
}

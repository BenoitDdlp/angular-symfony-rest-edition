<?php
/**
 *
 * @author benoitddlp
 */

namespace asre\OAuthServerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AuthorizeFormType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('allowAccess', 'checkbox', array(
      'label' => 'Allow access',
    ));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'asre\OAuthServerBundle\Form\Model\Authorize'
    ));
  }

  public function getName()
  {
    return 'asre_oauth_server_auth';
  }

}
<?php

namespace asre\SecurityBundle\Form;

use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileFormType extends BaseType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {

    // add your custom field
    $this->buildUserForm($builder, $options);

    $builder
      ->add('name')
      ->add('twitterScreenName', null, array(
        'required' => false
      ));
    parent::buildForm($builder, $options);
  }

  public function getName()
  {
    return 'asre_user_profile';
  }
}
<?php

namespace asre\CommunityBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrganizationType extends AgentType
{


  /**
   * @param FormBuilderInterface $builder
   * @param array                $options
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    parent::buildForm($builder, $options);

    $builder
      ->add('label');
  }

  /**
   * @param OptionsResolverInterface $resolver
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class'         => 'asre\CommunityBundle\Entity\Organization',
      'csrf_protection'    => false,
      'cascade_validation' => true,
    ));
  }

  /**
   * @return string
   */
  public function getName()
  {
    return 'asre_bundle_communitybundle_organization';
  }

}

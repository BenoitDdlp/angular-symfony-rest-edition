<?php

namespace asre\ContentBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class LocationType
 *
 * @package asre\ContentBundle\Form
 */
class LocationType extends LocalizationType
{
  /**
   * {@inheritdoc}
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    parent::buildForm($builder, $options);
    $builder
      ->add('capacity')
      ->add('description')
      ->add('accesibility');
  }

  /**
   * {@inheritdoc}
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(
      array(
        'data_class'      => 'asre\ContentBundle\Entity\Location',
        'csrf_protection' => false
      )
    );
  }

  /**
   * Returns the name of this type.
   *
   * @return string The name of this type
   */
  public function getName()
  {
    return 'asre_bundle_contentbundle_locationtype';
  }
}

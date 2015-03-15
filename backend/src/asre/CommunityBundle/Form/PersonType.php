<?php

namespace asre\CommunityBundle\Form;

use asre\RestBundle\Form\PatchSubscriber;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class PersonType
 *
 * @package asre\CommunityBundle\Form
 */
class PersonType extends AgentType
{

  /**
   * {@inheritdoc}
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    parent::buildForm($builder, $options);
    $builder
      ->add('firstName')
      ->add('familyName')
      ->add('twitter')
      ->add('share')
      ->add('label')
      ->add('email', 'email')
      ->add('positions', 'asre_collection_type', array(
        'type'     => new PositionType(),
        'required' => false
      ));
  }

  /**
   * {@inheritdoc}
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class'      => 'asre\CommunityBundle\Entity\Person',
      'csrf_protection' => false,
    ));
  }

  /**
   * Returns the name of this type.
   *
   * @return string The name of this type
   */
  public function getName()
  {
    return 'asre_communitybundle_persontype';
  }
}

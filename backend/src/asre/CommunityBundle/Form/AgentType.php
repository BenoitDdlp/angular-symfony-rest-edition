<?php

namespace asre\CommunityBundle\Form;

use asre\ContentBundle\Form\LocalizationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AgentType extends AbstractType
{
  /**
   * @param FormBuilderInterface $builder
   * @param array                $options
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('id')
      ->add('website')
      ->add('twitter')
      ->add('facebook')
      ->add('linkedIn')
      ->add('country')
      ->add('description')
      ->add('img')
      ->add('description')
      ->add('localization', 'asre_entity_type', array(
        'type'     => new LocalizationType(),
        'required' => false
      ))
      ->add('positions', 'asre_collection_type', array(
        'type'            => new PositionType(),
        'required'        => false,
        'cascade_persist' => false
      ));

  }

  /**
   * @param OptionsResolverInterface $resolver
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class'      => 'asre\CommunityBundle\Entity\Agent',
      'csrf_protection' => false,
    ));
  }

  /**
   * @return string
   */
  public function getName()
  {
    return 'asre_communitybundle_agent';
  }
}

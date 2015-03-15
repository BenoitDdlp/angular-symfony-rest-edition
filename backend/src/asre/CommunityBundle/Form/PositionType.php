<?php

namespace asre\CommunityBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PositionType extends AbstractType
{

  /**
   * @param FormBuilderInterface $builder
   * @param array                $options
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('id')
      ->add('position')
      ->add('label')
      ->add('person', 'asre_entity_type', array(
        'type'               => new PersonType(),
        'required'           => true,
        'cascade_persist'    => false,
        'allow_extra_fields' => true,
      ))
      ->add('organization', 'asre_entity_type', array(
        'type'     => new OrganizationType(),
        'required' => false
      ));
  }

  /**
   * @param OptionsResolverInterface $resolver
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class'         => 'asre\CommunityBundle\Entity\Position',
      'csrf_protection'    => false,
      'cascade_validation' => true,
    ));
  }

  /**
   * @return string
   */
  public function getName()
  {
    return 'asre_bundle_communitybundle_position';
  }

}

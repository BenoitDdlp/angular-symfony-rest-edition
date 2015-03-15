<?php
/**
 * @author benoitddlp
 * @see    http://symfony.com/fr/doc/current/cookbook/form/create_custom_field_type.html
 */
namespace asre\RestBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\EventListener\ResizeFormListener;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AsreCollectionType extends AbstractType
{

  protected $em;

  function __construct(EntityManager $em)
  {
    $this->em = $em;
  }

  /**
   * inspired by \Symfony\Component\Form\Extension\Core\Type\CollectionType->buildForm()
   * use the symfony's default Listener for collection  (@see \Symfony\Component\Form\Extension\Core\Type\CollectionType]
   * => build a 'asre_entity_type' instead of the one given in the 'type' param
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    //use the symfony's default Listener for collection  (@see \Symfony\Component\Form\Extension\Core\Type\CollectionType]
    // => build a 'asre_entity_type' instead of the one given in the 'type' param
    $options['options'] = array(
      'type'               => $options['type'],
      'cascade_persist'    => $options['cascade_persist'],
      'allow_extra_fields' => $options['allow_extra_fields'],
    );
    $resizeListener = new ResizeFormListener(
      'asre_entity_type',
      $options['options'],
      $options['allow_add'],
      $options['allow_delete'],
      $options['delete_empty']
    );

    $builder->addEventSubscriber($resizeListener);

    $transformer = new AsreCollectionTypeTransformer($this->em, $options);
    $builder->addModelTransformer($transformer);
  }

  /**
   * {@inheritdoc}
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'required'           => false,
      'allow_add'          => true,
      'allow_delete'       => true,
      'cascade_persist'    => true,
      'allow_extra_fields' => false,
      'delete_empty'       => false,
      'prototype'          => false,
      'options'            => array()
    ));
    $resolver->setRequired(array(
      'type',
    ));
  }

  /**
   * {@inheritdoc}
   */
  public function getName()
  {
    return 'asre_collection_type';
  }
}
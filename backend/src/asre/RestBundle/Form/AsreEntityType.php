<?php
/**
 * @author benoitddlp
 * @see    http://symfony.com/fr/doc/current/cookbook/form/create_custom_field_type.html
 */
namespace asre\RestBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AsreEntityType extends AbstractType
{

  protected $em;

  function __construct(EntityManager $em)
  {
    $this->em = $em;
  }

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $transformer = new AsreEntityTypeTransformer($this->em, $options);
    $builder->addModelTransformer($transformer);
    $extractId = new AsreExtractIdFormListener();

    $builder->addEventSubscriber($extractId);

    // Build the given form type from the required 'type' option.
    /** @var \Symfony\Component\Form\FormTypeInterface $formType */
    if (!$options['cascade_persist'])
    { //just make the link with the id field
      $builder->add('id');
    }
    else
    {
      $formType = $options['type'];
      $formType->buildForm($builder, $options);
    }
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'required'        => true,
      'cascade_persist' => true,
    ));
    $resolver->setRequired(array(
      'type'
    ));
  }

  public function getName()
  {
    return 'asre_entity_type';
  }
}
<?php
namespace asre\RestBundle\Services;


use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\EntityManagerInterface;

/**
 *  helper functions for business service like asre.PersonService
 *
 * @author benoitddlp
 */
abstract class AbstractBusinessService
{

  /** @var  Reader */
  protected $reader;
  /** @var  EntityManagerInterface */
  protected $entityManager;
  private $annotationClass = 'Doctrine\\ORM\\Mapping\\Column';

  /**
   * @param EntityManagerInterface $entityManager
   */
  public function setEntityManager(EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
  }

  /**
   * @param Reader $reader
   */
  public function setReader(Reader $reader)
  {
    $this->reader = $reader;
  }

  /**
   * check if an attribute has been changed, if so : return the old value
   *
   * @param mixed  $entity
   * @param string $attribute
   *
   * @return false | mixed the old attribute
   */
  protected function isDirty($entity, $attribute)
  {
    $uow = $this->entityManager->getUnitOfWork();
    $metaData = $this->entityManager->getClassMetadata(get_class($entity));
    $uow->computeChangeSet($metaData, $entity);
    $changeset = $uow->getEntityChangeSet($entity);

    return isset($changeset[$attribute]) ? $changeset[$attribute][0] : false;
  }
}
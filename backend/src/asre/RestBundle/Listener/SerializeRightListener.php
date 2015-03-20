<?php
/**
 *
 * @author benoitddlp
 */

namespace asre\RestBundle\Listener;

use asre\CommunityBundle\Entity\Person;
use asre\SecurityBundle\Entity\User;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Add data after serialization
 *
 */
class SerializeRightListener implements EventSubscriberInterface
{
  const FIELD = "right";

  const READ = "READ";
  const EDIT = "EDIT";

  private $logger;
  private $securityContext;

  function __construct(SecurityContextInterface $securityContext, LoggerInterface $logger = null)
  {
    $this->securityContext = $securityContext;
    $this->logger = $logger;
  }

  /**
   * @inheritdoc
   */
  static public function getSubscribedEvents()
  {
    return array(
      array('event' => 'serializer.post_serialize', 'method' => 'onPostSerialize'),
    );
  }

  /**
   * serialize right
   *
   * @param ObjectEvent $event
   */
  public function onPostSerialize(ObjectEvent $event)
  {
    $object = $event->getObject();

    $right = static::READ;

    if ($object instanceof Person && null != $object->getUser())
    {
      $currentUser = $this->securityContext->getToken()->getUser();
      /** $object Person */
      if ($currentUser instanceof User && $currentUser->getId()
        == $object->getUser()->getId()
      )
      {
        $right = self::EDIT;
      }
    }
    $event->getVisitor()->addData(self::FIELD, $right);
  }
}
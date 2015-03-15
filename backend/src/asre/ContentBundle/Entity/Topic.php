<?php

namespace asre\ContentBundle\Entity;

use asre\ContentBundle\Util\StringTools;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * This entity define a topic
 *
 * @ORM\Table(name="topic", options={"collate"="utf8_bin"})
 * @ORM\Entity(repositoryClass="asre\ContentBundle\Repository\TopicRepository")
 * @ORM\HasLifecycleCallbacks
 * @ExclusionPolicy("all")
 */
class Topic
{
  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue()
   * @Expose
   * @Groups({"list"})
   */
  private $id;

  /**
   * label
   *
   * @ORM\Column(type="string", unique=true)
   * @Expose
   * @Groups({"list"})
   */
  private $label;

  /**
   * @ORM\Column(type="string", length=128, nullable=true)
   */
  private $slug;

  /**
   * Constructor
   */
  public function __construct()
  {
  }

  /**
   * __toString method
   *
   * @return mixed
   */
  public function __toString()
  {
    return $this->label;

  }

  /**
   * onUpdate
   *
   * @ORM\PrePersist()
   * @ORM\PreUpdate()
   */
  public function onUpdate()
  {
    $this->slugify();
  }

  /**
   * Slugify
   *
   */
  public function slugify()
  {
    $this->setSlug(StringTools::slugify($this->getLabel(), false));
  }

  /**
   * Get label
   *
   * @return string
   */
  public function getLabel()
  {
    return $this->label;
  }

  /**
   * Set label
   *
   * @param string $label
   *
   * @return Topic
   */
  public function setLabel($label)
  {
    $this->label = $label;

    return $this;
  }

  /**
   * Get slug
   *
   * @return string
   */
  public function getSlug()
  {
    return $this->slug;
  }

  /**
   * Set slug
   *
   * @param string $slug
   *
   * @return $this
   */
  public function setSlug($slug)
  {
    $this->slug = $slug;

    return $this;
  }

  /**
   * Get id
   *
   * @return integer
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set id
   *
   * @param string $id
   *
   * @return $this
   */
  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }
}

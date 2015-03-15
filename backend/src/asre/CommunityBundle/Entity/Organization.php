<?php

namespace asre\CommunityBundle\Entity;

use asre\ContentBundle\Util\StringTools;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Constraints as Assert;


/**
 *
 * @ORM\Table(name="organization")
 * @ORM\Entity(repositoryClass="asre\CommunityBundle\Repository\OrganizationRepository")
 * @ORM\HasLifecycleCallbacks
 * @ExclusionPolicy("all")
 * @DoctrineAssert\UniqueEntity(fields={"label"}, message = "{'field' : 'position', 'msg' : 'organizations.validations.unique'}")
 */
class Organization extends Agent
{

  /**
   * label
   * @ORM\Column(type="string", unique=true, nullable=false)
   *
   * @Expose
   * @Groups({"list"})
   */
  protected $label;

  /**
   * @ORM\Column(type="string", length=256, nullable=true)
   */
  protected $slug;
  /**
   *
   * @ORM\OneToMany(targetEntity="Position",  mappedBy="organization",cascade={"persist","remove"})
   * @ORM\JoinColumn(onDelete="CASCADE")
   * @Expose
   */
  private $positions;

  /**
   * Constructor
   */
  public function __construct()
  {
  }

  /**
   * Method to string for the entity
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
   * @ORM\PostPersist()
   * @ORM\PreUpdate()
   */
  public function onUpdate()
  {
    $this->slugify();
  }

  /**
   * Slugify
   * @ORM\PrePersist()
   */
  public function slugify()
  {
    $this->setSlug(StringTools::slugify($this->getId() . $this->getLabel()));
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
   * @return $this
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
    $this->slugify();

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
   * @return mixed
   */
  public function getPositions()
  {
    return $this->positions;
  }

  /**
   * @param mixed $positions
   */
  public function setPositions($positions)
  {
    $this->positions = $positions;
  }


}

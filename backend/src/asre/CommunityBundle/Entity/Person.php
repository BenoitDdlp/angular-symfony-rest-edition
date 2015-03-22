<?php

namespace asre\CommunityBundle\Entity;

use asre\ContentBundle\Util\StringTools;
use asre\SecurityBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * This entity is based on the specification FOAF.
 *
 * This class define a Person.
 * @ORM\Table(name="person")
 *
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="asre\CommunityBundle\Repository\PersonRepository")
 * @ExclusionPolicy("ALL")
 *
 */
class Person extends Agent
{

  /**
   * @ORM\Column(type="string")
   * @Expose
   * @Groups({"list"})
   */
  protected $label;

  /**
   * technical user
   *
   * @ORM\OneToOne(targetEntity="asre\SecurityBundle\Entity\User", cascade={"all"}, inversedBy="person")
   * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="cascade")
   *
   */
  protected $user;

  /**
   * @ORM\Column(type="string", nullable=true,  name="familyName")
   * @Expose
   * @SerializedName("familyName")
   */
  protected $familyName;

  /**
   * @Assert\NotBlank(message = "{'field' : 'firstNames', 'msg' : 'positions.validations.first_name_required'}")
   * @ORM\Column(type="string", nullable=true,  name="firstName")
   * @Expose
   * @SerializedName("firstName")
   */
  protected $firstName;

  /**
   * @ORM\Column(type="integer", nullable=true,  name="age")
   * @Expose
   */
  protected $age;


  /**
   * @ORM\Column(type="string", nullable=true,  name="openId")
   */
  protected $openId;

  /**
   * @ORM\Column(type="string", length=256, nullable=true)
   */
  protected $slug;

  /**
   *  Person that invited this person
   * @ORM\ManyToOne(targetEntity="Person",  inversedBy="guests", cascade={"all"})
   * @ORM\JoinColumn(onDelete="CASCADE")
   */
  protected $invitedBy;
  /**
   * twitter hashtag
   *
   * This property defines the hashtag of the event resource
   *
   * @ORM\Column(type="string", length=255, nullable=true)
   * @expose
   */
  protected $twitter;
  /**
   * share
   *
   * This property defines whether we display share buttons or not
   *
   * @ORM\Column(type="boolean")
   * @Expose
   */
  protected $share = true;
  /**
   * @ORM\OneToMany(targetEntity="asre\CommunityBundle\Entity\Position", mappedBy="person", cascade={"all"}, orphanRemoval=true)
   * @Expose
   */
  private $positions;
  /**
   *  Persons invited by this person
   * @ORM\OneToMany(targetEntity="Person", mappedBy="invitedBy", cascade={"all"}, orphanRemoval=true)
   */
  private $guests;

  /**
   * Constructor
   */
  public function __construct()
  {
    $this->positions = new ArrayCollection();
    $this->guests = new ArrayCollection();
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
   * onCreation
   *
   * @ORM\PrePersist()
   * @ORM\PreUpdate()
   */
  public function computeLabel()
  {
    $this->setLabel($this->firstName . " " . $this->familyName);
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
   * Get familyName
   *
   * @return string
   */
  public function getFamilyName()
  {
    return $this->familyName;
  }

  /**
   * Set familyName
   *
   * @param string $familyName
   *
   * @return $this
   */
  public function setFamilyName($familyName)
  {
    $this->familyName = $familyName;

    return $this;
  }

  /**
   * Get firstName
   *
   * @return string
   */
  public function getFirstName()
  {
    return $this->firstName;
  }

  /**
   * Set firstName
   *
   * @param string $firstName
   *
   * @return $this
   */
  public function setFirstName($firstName)
  {
    $this->firstName = $firstName;

    return $this;
  }

  /**
   * Get age
   *
   * @return integer
   */
  public function getAge()
  {
    return $this->age;
  }

  /**
   * Set age
   *
   * @param integer $age
   *
   * @return $this
   */
  public function setAge($age)
  {
    $this->age = $age;

    return $this;
  }

  /**
   * Get openId
   *
   * @return string
   */
  public function getOpenId()
  {
    return $this->openId;
  }

  /**
   * Set openId
   *
   * @param string $openId
   *
   * @return $this
   */
  public function setOpenId($openId)
  {
    $this->openId = $openId;

    return $this;
  }

  /**
   * Add position
   *
   * @param Position $position
   *
   * @return User
   */
  public function addPosition(Position $position)
  {
    $this->positions[] = $position;

    $position->setPerson($this);

//        echo "addPosition to :" . $position->getPerson()->getLabel();

    return $this;
  }

  /**
   * Remove positions
   *
   * @param Position $position
   */
  public function removePosition(Position $position)
  {
    $this->positions->removeElement($position);
  }

  /**
   * Get positions
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getPositions()
  {
    return $this->positions;
  }

  /**
   * @return \asre\SecurityBundle\Entity\User
   */
  public function getUser()
  {
    return $this->user;
  }

  /**
   * @param \asre\SecurityBundle\Entity\User $user
   */
  public function setUser(User $user = null)
  {
    if ($user != null)
    {
      $user->setPerson($this);
    }
    $this->user = $user;
  }

  /**
   * @return Person
   */
  public function getInvitedBy()
  {
    return $this->invitedBy;
  }

  /**
   * @param Person $invitedBy
   */
  public function setInvitedBy(Person $invitedBy)
  {
    $this->invitedBy = $invitedBy;
  }

  /**
   * Add guests
   *
   * @param Person $guests
   *
   * @return $this
   */
  public function addGuest(Person $guests)
  {
    $this->guests[] = $guests;

    return $this;
  }

  /**
   * Remove guests
   *
   * @param Person $guests
   */
  public function removeGuest(Person $guests)
  {
    $this->guests->removeElement($guests);
  }

  /**
   * Get guests
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getGuests()
  {
    return $this->guests;
  }

  /**
   * @param mixed $guests
   */
  public function setGuests($guests)
  {
    $this->guests = $guests;
  }

  /**
   * @return mixed
   */
  public function getTwitter()
  {
    return $this->twitter;
  }

  /**
   * @param mixed $twitter
   */
  public function setTwitter($twitter)
  {
    $this->twitter = $twitter;
  }

  /**
   * @return bool
   */
  public function getShare()
  {
    return $this->share;
  }

  /**
   * @param bool $share
   */
  public function setShare($share)
  {
    $this->share = $share;
  }
}
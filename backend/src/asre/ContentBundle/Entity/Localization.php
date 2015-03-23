<?php

namespace asre\ContentBundle\Entity;

use asre\ImportBundle\Annotation\Importer;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * localization entity
 * A localization is a geographic point with geocoding information
 * @ORM\Table(name="localization")
 * @ORM\Entity(repositoryClass="asre\ContentBundle\Repository\LocalizationRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorMap({
 *     "Location"="Location",
 *     "Localization"="Localization",
 * })
 * @ExclusionPolicy("all")
 */
class Localization
{
  /**
   * fix an issue with jms-serializer and form validation when applied to a doctrine InheritanceType("SINGLE_TABLE")
   */
  public $dtype;
  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   * @Expose
   * @Groups({"list"})
   */
  protected $id;

  /**
   * @ORM\Column(type="string", length=255)
   * @Expose
   * @Groups({"list"})
   *
   */
  protected $label;
  /**
   * @ORM\Column(type="decimal", precision=10, scale=6, nullable=true)
   *
   * @Assert\Length(
   *      min = "-90",
   *      max = "90",
   *      minMessage = "You must be between -90 and 90.",
   *      maxMessage = "You must be between -90 and 90."
   * )
   * @Expose
   * @Groups({"list"})
   */
  protected $latitude;
  /**
   * @ORM\Column(type="decimal", precision=10, scale=6, nullable=true)
   * @Assert\Length(
   *      min = "-180",
   *      max = "180",
   *      minMessage = "You must be between -180 and 180.",
   *      maxMessage = "You must be between -180 and 180."
   * )
   * @Expose
   * @Groups({"list"})
   */
  protected $longitude;
  /**
   * address
   * The fully formatted address line containing street number, street, city, state, country
   * @ORM\Column(type="string", nullable=true)
   *
   * @Expose
   * @Groups({"list"})
   */
  protected $address;
  /**
   * street
   *
   * @ORM\Column(type="string", nullable=true)
   * @Expose
   * @Groups({"list"})
   */
  protected $street;
  /**
   * street number
   *
   * @ORM\Column(type="integer", nullable=true)
   * @SerializedName("streetNumber")
   * @Expose
   * @Groups({"list"})
   */
  protected $streetNumber;
  /**
   * city
   *
   * @ORM\Column(type="string", nullable=true)
   * @Expose
   * @Groups({"list"})
   */
  protected $city;
  /**
   * state
   *
   * @ORM\Column(type="string", nullable=true)
   * @Expose
   * @Groups({"list"})
   */
  protected $state;
  /**
   * country
   * @ORM\Column(type="string", nullable=true)
   *
   * @Expose
   */
  protected $country;
  /**
   * country code
   * @ORM\Column(type="string", nullable=true)
   * @SerializedName("countryCode")
   *
   * @Expose
   * @Groups({"list"})
   */
  protected $countryCode;
  /**
   * postalCode code
   * @ORM\Column(type="string", nullable=true)
   * @SerializedName("postalCode")
   *
   * @Expose
   * @Groups({"list"})
   */
  protected $postalCode;

  /**
   * @ORM\OneToOne(targetEntity="asre\CommunityBundle\Entity\Person", cascade={"all"})
   * @ORM\JoinColumn(name="uid", referencedColumnName="id", onDelete="cascade")
   * @Expose
   * @MaxDepth(2)
   */
  protected $person;

  /**
   * toString
   *
   * @return string
   */
  public function __toString()
  {
    return $this->getLabel();
  }

  /**
   * Get name
   *
   * @return string
   */
  public function getLabel()
  {
    return $this->label;
  }

  /**
   * Set name
   *
   * @param $label
   *
   * @return Location
   */
  public function setLabel($label)
  {
    $this->label = $label;

    return $this;
  }

  /**
   * Get latitude
   *
   * @return float
   */
  public function getLatitude()
  {
    return $this->latitude;
  }

  /**
   * Set latitude
   *
   * @param float $latitude
   *
   * @return Location
   */
  public function setLatitude($latitude)
  {
    $this->latitude = $latitude;

    return $this;
  }

  /**
   * Get longitude
   *
   * @return float
   */
  public function getLongitude()
  {
    return $this->longitude;
  }

  /**
   * Set longitude
   *
   * @param float $longitude
   *
   * @return Location
   */
  public function setLongitude($longitude)
  {
    $this->longitude = $longitude;

    return $this;
  }

  /**
   * @return mixed
   */
  public function getDtype()
  {
    return $this->dtype;
  }

  /**
   * @param mixed $dtype
   */
  public function setDtype($dtype)
  {
    $this->dtype = $dtype;
  }


  /**
   * @return mixed
   */
  public function getCity()
  {
    return $this->city;
  }

  /**
   * @param mixed $city
   */
  public function setCity($city)
  {
    $this->city = $city;
  }

  /**
   * @return mixed
   */
  public function getCountry()
  {
    return $this->country;
  }

  /**
   * @param mixed $country
   */
  public function setCountry($country)
  {
    $this->country = $country;
  }

  /**
   * @return mixed
   */
  public function getCountryCode()
  {
    return $this->countryCode;
  }

  /**
   * @param mixed $countryCode
   */
  public function setCountryCode($countryCode)
  {
    $this->countryCode = $countryCode;
  }

  /**
   * @return mixed
   */
  public function getStreet()
  {
    return $this->street;
  }

  /**
   * @param mixed $street
   */
  public function setStreet($street)
  {
    $this->street = $street;
  }

  /**
   * @return mixed
   */
  public function getStreetNumber()
  {
    return $this->streetNumber;
  }

  /**
   * @param mixed $streetNumber
   */
  public function setStreetNumber($streetNumber)
  {
    $this->streetNumber = $streetNumber;
  }


  /**
   * @return mixed
   */
  public function getAddress()
  {
    return $this->address;
  }

  /**
   * @param mixed $address
   */
  public function setAddress($address)
  {
    $this->address = $address;
  }

  /**
   * @return mixed
   */
  public function getPerson()
  {
    return $this->person;
  }

  /**
   * @param mixed $person
   */
  public function setPerson($person)
  {
    $this->person = $person;
  }

  /**
   * @return mixed
   */
  public function getPostalCode()
  {
    return $this->postalCode;
  }

  /**
   * @param mixed $postalCode
   */
  public function setPostalCode($postalCode)
  {
    $this->postalCode = $postalCode;
  }

  /**
   * @return mixed
   */
  public function getState()
  {
    return $this->state;
  }

  /**
   * @param mixed $state
   */
  public function setState($state)
  {
    $this->state = $state;
  }

  /**
   * @return mixed
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @param mixed $id
   */
  public function setId($id)
  {
    $this->id = $id;
  }
}

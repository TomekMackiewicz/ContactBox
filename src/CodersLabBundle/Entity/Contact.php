<?php

namespace CodersLabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Contact
 *
 * @ORM\Table(name="contacts")
 * @ORM\Entity(repositoryClass="CodersLabBundle\Repository\ContactRepository")
 */
class Contact
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=64)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;


    // Relacje
    
    /**
    * @ORM\OneToOne(targetEntity="Address", mappedBy="contact_id")
    */
    private $address; 

    /**
    * @ORM\OneToOne(targetEntity="Phone", mappedBy="contact_id")
    */
    private $phone; 

    /**
    * @ORM\OneToOne(targetEntity="Email", mappedBy="contact_id")
    */
    private $email;

    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="contacts")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $userId;

    /**
    * @ORM\ManyToMany(targetEntity="Team", inversedBy="contacts")
    * @ORM\JoinTable(name="contacts_teams")
    */
    private $teams;

    public function __construct() {
        $this->teams = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Contact
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return Contact
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Contact
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set address
     *
     * @param \CodersLabBundle\Entity\Address $address
     * @return Contact
     */
    public function setAddress(\CodersLabBundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \CodersLabBundle\Entity\Address 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Get addressId
     *
     * @return \CodersLabBundle\Entity\Address 
     */
    public function getAddressId()
    {
        return $this->address->getId();
    }

    /**
     * Set phone
     *
     * @param \CodersLabBundle\Entity\Phone $phone
     * @return Contact
     */
    public function setPhone(\CodersLabBundle\Entity\Phone $phone = null)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return \CodersLabBundle\Entity\Phone 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Get phoneId
     *
     * @return \CodersLabBundle\Entity\Phone 
     */
    public function getPhoneId()
    {
        return $this->phone->getId();
    }


    /**
     * Set email
     *
     * @param \CodersLabBundle\Entity\Email $email
     * @return Contact
     */
    public function setEmail(\CodersLabBundle\Entity\Email $email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return \CodersLabBundle\Entity\Email 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get phoneId
     *
     * @return \CodersLabBundle\Entity\Email 
     */
    public function getEmailId()
    {
        return $this->email->getId();
    }

    /**
     * Add teams
     *
     * @param \CodersLabBundle\Entity\Team $teams
     * @return Contact
     */
    public function addTeam(\CodersLabBundle\Entity\Team $teams)
    {
        $this->teams[] = $teams;

        return $this;
    }

    /**
     * Remove teams
     *
     * @param \CodersLabBundle\Entity\Team $teams
     */
    public function removeTeam(\CodersLabBundle\Entity\Team $teams)
    {
        $this->teams->removeElement($teams);
    }

    /**
     * Get teams
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeams()
    {
        return $this->teams;
    }


    /**
     * Set userId
     *
     * @param \CodersLabBundle\Entity\User $userId
     * @return Contact
     */
    public function setUserId(\CodersLabBundle\Entity\User $userId = null)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return \CodersLabBundle\Entity\User 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    public function __toString() {
        return $this->name.' '.$this->surname;
    }

}

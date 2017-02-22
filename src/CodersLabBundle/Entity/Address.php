<?php

namespace CodersLabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 *
 * @ORM\Table(name="addresses")
 * @ORM\Entity(repositoryClass="CodersLabBundle\Repository\AddressRepository")
 */
class Address
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
     * @ORM\Column(name="full_address", type="text")
     */
    private $fullAddress;


    // Relacje
    
    /**
    * @ORM\OneToOne(targetEntity="Contact", inversedBy="address")
    * @ORM\JoinColumn(name="contact_id", referencedColumnName="id", onDelete="CASCADE")    
    */
    private $contact_id; 

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
     * Set fullAddress
     *
     * @param string $fullAddress
     * @return Address
     */
    public function setFullAddress($fullAddress)
    {
        $this->fullAddress = $fullAddress;

        return $this;
    }

    /**
     * Get fullAddress
     *
     * @return string 
     */
    public function getFullAddress()
    {
        return $this->fullAddress;
    }

    /**
     * Set contact_id
     *
     * @param \CodersLabBundle\Entity\Contact $contactId
     * @return Address
     */
    public function setContactId(\CodersLabBundle\Entity\Contact $contactId = null)
    {
        $this->contact_id = $contactId;

        return $this;
    }

    /**
     * Get contact_id
     *
     * @return \CodersLabBundle\Entity\Contact 
     */
    public function getContactId()
    {
        return $this->contact_id;
    }

    public function __toString() {
        return $this->fullAddress;
    }

}

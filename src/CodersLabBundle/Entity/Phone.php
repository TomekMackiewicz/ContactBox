<?php

namespace CodersLabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Phone
 *
 * @ORM\Table(name="phones")
 * @ORM\Entity(repositoryClass="CodersLabBundle\Repository\PhoneRepository")
 */
class Phone
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
     * @ORM\Column(name="phone", type="string", length=32)
     */
    private $phone;

    // Relacje
    
    /**
    * @ORM\OneToOne(targetEntity="Contact", inversedBy="phone")
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
     * Set phone
     *
     * @param string $phone
     * @return Phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set contact_id
     *
     * @param \CodersLabBundle\Entity\Contact $contactId
     * @return Phone
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
        return $this->phone;
    }

}

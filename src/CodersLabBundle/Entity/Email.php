<?php

namespace CodersLabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Email
 *
 * @ORM\Table(name="emails")
 * @ORM\Entity(repositoryClass="CodersLabBundle\Repository\EmailRepository")
 */
class Email
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
     * @ORM\Column(name="emails", type="string", length=64)
     */
    private $email;

    // Relacje
    
    /**
    * @ORM\OneToOne(targetEntity="Contact", inversedBy="email")
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
     * Set email
     *
     * @param string $email
     * @return Email
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set contact_id
     *
     * @param \CodersLabBundle\Entity\Contact $contactId
     * @return Email
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
        return $this->email;
    }

}

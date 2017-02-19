<?php

namespace CodersLabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Email
 *
 * @ORM\Table(name="email")
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
     * @ORM\Column(name="email", type="string", length=64)
     */
    private $email;

    // Relacje
    
    /**
    * @ORM\OneToOne(targetEntity="Contact", inversedBy="email")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")    
    */
    private $user_id;

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

    public function __toString() {
        return $this->email;
    }


    /**
     * Set user_id
     *
     * @param \CodersLabBundle\Entity\Contact $userId
     * @return Email
     */
    public function setUserId(\CodersLabBundle\Entity\Contact $userId = null)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return \CodersLabBundle\Entity\Contact 
     */
    public function getUserId()
    {
        return $this->user_id;
    }
}

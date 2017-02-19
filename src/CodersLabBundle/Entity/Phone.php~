<?php

namespace CodersLabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Phone
 *
 * @ORM\Table(name="phone")
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
     * Set user_id
     *
     * @param \CodersLabBundle\Entity\Contact $userId
     * @return Phone
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

    public function __toString() {
        return $this->phone;
    }
    
}

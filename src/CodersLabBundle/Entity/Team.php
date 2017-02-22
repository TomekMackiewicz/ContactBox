<?php

namespace CodersLabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Team
 *
 * @ORM\Table(name="teams")
 * @ORM\Entity(repositoryClass="CodersLabBundle\Repository\TeamRepository")
 */
class Team
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
     * @ORM\Column(name="team", type="string", length=64)
     */
    private $team;

    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="teams")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $userId;

    /**
    * @ORM\ManyToMany(targetEntity="Contact", mappedBy="teams")
    */
    private $contacts;
    
    public function __construct() {
        $this->contacts = new ArrayCollection();
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
     * Set team
     *
     * @param string $team
     * @return Team
     */
    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return string 
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Add contacts
     *
     * @param \CodersLabBundle\Entity\Contact $contacts
     * @return Team
     */
    public function addContact(\CodersLabBundle\Entity\Contact $contacts)
    {
        $this->contacts[] = $contacts;

        return $this;
    }

    /**
     * Remove contacts
     *
     * @param \CodersLabBundle\Entity\Contact $contacts
     */
    public function removeContact(\CodersLabBundle\Entity\Contact $contacts)
    {
        $this->contacts->removeElement($contacts);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    public function __toString() {
        return $this->team;
    }


    /**
     * Set userId
     *
     * @param \CodersLabBundle\Entity\User $userId
     * @return Team
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
}

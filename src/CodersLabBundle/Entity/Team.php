<?php

namespace CodersLabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Team
 *
 * @ORM\Table(name="team")
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

}

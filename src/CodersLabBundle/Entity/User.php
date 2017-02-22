<?php

namespace CodersLabBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
* @ORM\Entity
* @ORM\Table(name="users")
* @ORM\Entity(repositoryClass="CodersLabBundle\Repository\UserRepository")
*/
class User extends BaseUser
{
	/**
	* @ORM\Id
	* @ORM\Column(type="integer")
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;

  /**
  * @ORM\OneToMany(targetEntity="Contact", mappedBy="userId")
  */
  private $contacts;

  /**
  * @ORM\OneToMany(targetEntity="Team", mappedBy="userId")
  */
  private $teams;

  public function __construct() {
    $this->contacts = new ArrayCollection();
    $this->teams = new ArrayCollection();
  }  

	// public function __construct()
	// {
	// 	parent::__construct();
	// }

    /**
     * Add contacts
     *
     * @param \CodersLabBundle\Entity\Contact $contacts
     * @return User
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

    /**
     * Add teams
     *
     * @param \CodersLabBundle\Entity\Team $teams
     * @return User
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
}

<?php

namespace CodersLabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use CodersLabBundle\Entity\Team;
use CodersLabBundle\Entity\Contact;
use CodersLabBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
* @Route("/team")
*/
class TeamController extends Controller
{

	// -----------------------------------------
	//
	//    Show all teams
	//
	// -----------------------------------------

	/**
	* @Route("/showTeams")	
	* @Method("GET")
	* @Template()
	*/
	public function showTeamsAction()
	{
		$user = $this->getUser();
		$repo = $this->getDoctrine()->getManager()->getRepository('CodersLabBundle:Team');
		//$teams = $repo->findAll();
		$teams = $repo->findByUserId($user->getId(), array('team'=>'asc'));

		return ['teams' => $teams];
	}

	// -----------------------------------------
	//
	//    Show team
	//
	// -----------------------------------------

	/**
	* @Route("/{id}", requirements={"id" = "\d+"})
	* @Method("GET")
	* @Template()
	*/
	public function showTeamAction($id, \CodersLabBundle\Entity\Contact $contacts = null) 
	{
		$user = $this->getUser();
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('CodersLabBundle:Team');
		$team = $repo->find($id);	
		$repoContacts = $em->getRepository('CodersLabBundle:Contact');
		//$allContacts = $repoContacts->findAll();
		$allContacts = $repoContacts->findByUserId($user->getId(), array('surname'=>'asc'));
		$contacts = $team->getContacts();

		return ['team' => $team, 'contacts' => $contacts, 'allContacts' => $allContacts];
	}

	// -----------------------------------------
	//
	//    Add team
	//
	// -----------------------------------------

	/**
	* @Route("/newTeam")
	* @Method("GET")
	* @Template()
	*/
	public function newTeamAction()
	{
		$team = new Team();
		$form = $this->getNewTeamForm($team);
		return ['form' => $form->createView()];
	}

	/**
	* @Route("/newTeam")
	* @Method("POST")
	* @Template()
	*/
	public function createTeamAction(Request $req)
	{
		$team = new Team();
		$form = $this->getNewTeamForm($team);
		$form->handleRequest($req); 

		if($form->isSubmitted()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($team);
			$em->flush();
		}
		return $this->redirectToRoute('coderslab_team_showteams');
	}

	// -----------------------------------------
	//
	//    Edit teams
	//
	// -----------------------------------------

	/**
	* @Route("/{id}/modifyteam")
	* @Method("GET")
	* @Template()
	*/
	public function editTeamAction($id)
	{
		$team = $this
			->getDoctrine()
			->getManager()
			->getRepository('CodersLabBundle:Team')
			->find($id);
			$form = $this->getEditTeamForm($team);
		return ['form' => $form->createView()];
	}

	/**
	* @Route("/{id}/modifyteam")
	* @Method("POST")
	*/
	public function updateTeamAction(Request $req, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('CodersLabBundle:Team');
		$team = $repo->find($id);		
		$form = $this->getEditTeamForm($team);
		$form->handleRequest($req); 

		if($form->isSubmitted()) {
			$em = $this->getDoctrine()->getManager();
			$em->flush($team);
		}
		return $this->redirectToRoute('coderslab_team_showteams');
	}

	// -----------------------------------------
	//
	//    Delete team
	//
	// -----------------------------------------

	/**
	* @Route("/{id}/deleteteam")
	* @Method("GET")
	*/
	public function deleteTeamAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('CodersLabBundle:Team');
		$team = $repo->find($id);	
		$em->remove($team);
		$em->flush($team);	
		return $this->redirectToRoute('coderslab_team_showteams');
	}

	// -----------------------------------------
	//
	//    Add contact
	//
	// -----------------------------------------

	/**
	* @Route("/addContact/")
	* @Method("POST")
	*/		
	public function addContact()
	{
		$teamId = $_POST['team'];
		$contactId = $_POST['contact'];
		$em = $this->getDoctrine()->getManager();
		$repoC = $this->getDoctrine()->getManager()->getRepository('CodersLabBundle:Contact');
		$repoT = $this->getDoctrine()->getManager()->getRepository('CodersLabBundle:Team');
		$contact = $repoC->find($contactId);
		$team = $repoT->find($teamId);
		$team->addContact($contact);
		$contact->addTeam($team);
		$em->persist($team); 
		$em->persist($contact);
		$em->flush();

		return $this->redirectToRoute('coderslab_team_showteam', ['id'=> $teamId]);
	}

	// -----------------------------------------
	//
	//    Remove contact
	//
	// -----------------------------------------

	/**
	* @Route("/removeContact/")
	* @Method("POST")
	*/		
	public function removeContact()
	{
		$teamId = $_POST['team'];
		$contactId = $_POST['contact'];
		$em = $this->getDoctrine()->getManager();
		$repoC = $this->getDoctrine()->getManager()->getRepository('CodersLabBundle:Contact');
		$repoT = $this->getDoctrine()->getManager()->getRepository('CodersLabBundle:Team');
		$contact = $repoC->find($contactId);
		$team = $repoT->find($teamId);
		$team->getContacts()->removeElement($contact);
		$contact->getTeams()->removeElement($team);
		$em->flush();

		return $this->redirectToRoute('coderslab_team_showteam', ['id'=> $teamId]);
	}

	// -----------------------------------------
	//
	//    Forms
	//
	// -----------------------------------------

	private function getNewTeamForm($team)
	{
		$user = $this->getUser();
		$form = $this->createFormBuilder($team);
		$form->setAction($this->generateUrl('coderslab_team_createteam'));
		$form->add('team');

		$form->add('userId', EntityType::class, array(
		    'class' => 'CodersLabBundle:User',
		    'data' => $user->getId(),
		    'label' => false
		    //'attr' => array('style'=>'display:none;')
		));

		$form->add('save', 'submit');
		
		return $form->getForm();
	}

	private function getEditTeamForm($team)
	{
		$form = $this->createFormBuilder($team);
		$form->setAction($this->generateUrl('coderslab_team_updateteam', ['id'=>$team->getId()]));
		$form->add('team');
		$form->add('update', 'submit');
		
		return $form->getForm();
	}

}
<?php

namespace CodersLabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use CodersLabBundle\Entity\Team;
use CodersLabBundle\Entity\Contact;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

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
		$repo = $this->getDoctrine()->getManager()->getRepository('CodersLabBundle:Team');
		$teams = $repo->findAll();

		return ['teams' => $teams];
	}

	// -----------------------------------------
	//
	//    Show team
	//
	// -----------------------------------------

	/**
	* @Route("/{id}")
	* @Method("GET")
	* @Template()
	*/
	public function showTeamAction($id, \CodersLabBundle\Entity\Contact $contacts = null) 
	{
		// Manager encji
		$em = $this->getDoctrine()->getManager();
		// Bierzemy repozytorium encji
		$repo = $em->getRepository('CodersLabBundle:Team');
		$team = $repo->find($id);	

		$repoContacts = $em->getRepository('CodersLabBundle:Contact');
		$allContacts = $repoContacts->findAll();

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
		// Konstruujemy formularz, potrzebujemy danych
		$team = new Team();
		// Wywołujemy metodę budującą szablon formularza
		$form = $this->getNewTeamForm($team);
		// musi być createView()
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

		// Obsługujemy dane przychodzace z formularza
		// Team zostaje ustawiony (nie potrzebujemy robić set dla każdej wartości)
		$form->handleRequest($req); 

		// Można jeszcze dodać isValid()
		if($form->isSubmitted()) {
			// Manager encji
			$em = $this->getDoctrine()->getManager();
			// Chcemy dodać...
			$em->persist($team);
			// Dodajemy...
			// Flush może być bez parametru, wtedy wszystkie obiekty (wszystie zmiany)
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
		// Inny zapis tego samego, co w create i delete
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
		// Manager encji
		$em = $this->getDoctrine()->getManager();
		// Bierzemy repozytorium encji
		$repo = $em->getRepository('CodersLabBundle:Team');
		$team = $repo->find($id);		

		$form = $this->getEditTeamForm($team);

		// Obsługujemy dane przychodzace z formularza
		// Contact zostaje ustawiony (nie potrzebujemy robić set dla każdej wartości)
		$form->handleRequest($req); 

		// Można jeszcze dodać isValid()
		if($form->isSubmitted()) {
			// Manager encji
			$em = $this->getDoctrine()->getManager();
			// Dodajemy (przy update bez persist)...
			// Flush może być bez parametru, wtedy wszystkie obiekty (wszystie zmiany)
			$em->flush($team);
			// Albo krócej:
			// $this->getDoctrine()->getManager()->flush($contact);
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
		// Manager encji
		$em = $this->getDoctrine()->getManager();
		// Bierzemy repozytorium encji
		$repo = $em->getRepository('CodersLabBundle:Team');
		$team = $repo->find($id);
		// Chcemy usunąć...	
		$em->remove($team);
		// Usuwamy...
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

		// $em->removeTeam($team); 
		// $em->removeContact($contact);

		$team->getContacts()->remove($contactId);
		//$contact->getTeams()->remove($teamId);
		$contact->setTeams(null);

		$em->flush();
		return $this->redirectToRoute('coderslab_team_showteam', ['id'=> $teamId]);
	}

	// -----------------------------------------
	//
	//    Forms
	//
	// -----------------------------------------

	// Formularz zapisu
	private function getNewTeamForm($team)
	{
		// mechanizm do tworzenia formularzy
		$form = $this->createFormBuilder($team);
		// akcja
		$form->setAction($this->generateUrl('coderslab_team_createteam'));
		$form->add('team');	
		$form->add('save', 'submit');
		
		// zwracamy formularz
		return $form->getForm();
	}

	// Formularz edycji
	private function getEditTeamForm($team)
	{
		// mechanizm do tworzenia formularzy
		$form = $this->createFormBuilder($team);
		// akcja
		$form->setAction($this->generateUrl('coderslab_team_updateteam', ['id'=>$team->getId()]));
		// dodajemy pola
		$form->add('team');
		$form->add('update', 'submit');
		
		// zwracamy formularz
		return $form->getForm();
	}



}

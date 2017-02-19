<?php

namespace CodersLabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use CodersLabBundle\Entity\Contact;

class ContactController extends Controller
{

	// -----------------------------------------
	//
	//    Add contact
	//
	// -----------------------------------------

	/**
	* @Route("/new")
	* @Method("GET")
	* @Template()
	*/
	public function newAction()
	{
		// Konstruujemy formularz, potrzebujemy danych
		$contact = new Contact();
		// Wywołujemy metodę budującą szablon formularza
		$form = $this->getNewForm($contact);
		// musi być createView()
		return ['form' => $form->createView()];
	}

	/**
	* @Route("/new")
	* @Method("POST")
	* @Template()
	*/
	public function createAction(Request $req)
	{
		$contact = new Contact();
		$form = $this->getNewForm($contact);

		// Obsługujemy dane przychodzace z formularza
		// Contact zostaje ustawiony (nie potrzebujemy robić set dla każdej wartości)
		$form->handleRequest($req); 

		// Można jeszcze dodać isValid()
		if($form->isSubmitted()) {
			// Manager encji
			$em = $this->getDoctrine()->getManager();
			// Chcemy dodać...
			$em->persist($contact);
			// Dodajemy...
			// Flush może być bez parametru, wtedy wszystkie obiekty (wszystie zmiany)
			$em->flush($contact);
		}
		return $this->redirectToRoute('coderslab_contact_index');
	}

	// -----------------------------------------
	//
	//    Show all contacts
	//
	// -----------------------------------------

	/**
	* @Route("/")
	* @Method("GET")
	* @Template()
	*/
	public function indexAction()
	{
		// Manager encji
		$em = $this->getDoctrine()->getManager();
		// Bierzemy repozytorium encji
		$repo = $em->getRepository('CodersLabBundle:Contact');
		//$contacts = $repo->findAll();
		$contacts = $repo->findBy(array(), array('surname'=>'asc'));
		return ['contacts' => $contacts];
	}	

	// -----------------------------------------
	//
	//    Show contact
	//
	// -----------------------------------------

	/**
	* @Route("/{id}")
	* @Method("GET")
	* @Template()
	*/
	public function showAction($id)
	{
		// Manager encji
		$em = $this->getDoctrine()->getManager();
		// Bierzemy repozytorium encji
		$repo = $em->getRepository('CodersLabBundle:Contact');
		$contact = $repo->find($id);		
		return ['contact' => $contact];
	}

	// -----------------------------------------
	//
	//    Edit contact
	//
	// -----------------------------------------

	/**
	* @Route("/{id}/modify")
	* @Method("GET")
	* @Template()
	*/
	public function editAction($id)
	{
		// Inny zapis tego samego, co w create i delete
		$contact = $this
			->getDoctrine()
			->getManager()
			->getRepository('CodersLabBundle:Contact')
			->find($id);

			$form = $this->getEditForm($contact);
		return ['form' => $form->createView(), 'contact' => $contact];
	}

	/**
	* @Route("/{id}/modify")
	* @Method("POST")
	*/
	public function updateAction(Request $req, $id)
	{
		// Manager encji
		$em = $this->getDoctrine()->getManager();
		// Bierzemy repozytorium encji
		$repo = $em->getRepository('CodersLabBundle:Contact');
		$contact = $repo->find($id);		

		$form = $this->getEditForm($contact);

		// Obsługujemy dane przychodzace z formularza
		// Contact zostaje ustawiony (nie potrzebujemy robić set dla każdej wartości)
		$form->handleRequest($req); 

		// Można jeszcze dodać isValid()
		if($form->isSubmitted()) {
			// Manager encji
			$em = $this->getDoctrine()->getManager();
			// Dodajemy (przy update bez persist)...
			// Flush może być bez parametru, wtedy wszystkie obiekty (wszystie zmiany)
			$em->flush($contact);
			// Albo krócej:
			// $this->getDoctrine()->getManager()->flush($contact);
		}
		return $this->redirectToRoute('coderslab_contact_index');
	}

	// -----------------------------------------
	//
	//    Delete contact
	//
	// -----------------------------------------

	/**
	* @Route("/{id}/delete")
	* @Method("GET")
	*/
	public function deleteAction($id)
	{
		// Manager encji
		$em = $this->getDoctrine()->getManager();
		// Bierzemy repozytorium encji
		$repo = $em->getRepository('CodersLabBundle:Contact');
		$contact = $repo->find($id);
		// Chcemy usunąć...	
		$em->remove($contact);
		// Usuwamy...
		$em->flush($contact);	
		return $this->redirectToRoute('coderslab_contact_index');
	}

	// -----------------------------------------
	//
	//    Forms
	//
	// -----------------------------------------

	// Formularz zapisu
	private function getNewForm($contact)
	{
		// mechanizm do tworzenia formularzy
		$form = $this->createFormBuilder($contact);
		// akcja
		$form->setAction($this->generateUrl('coderslab_contact_create'));
		// dodajemy pola
		// $form->add('name', null, [ // atrybuty tu lub zob widok
		// 	'attr' => [
		// 		'class' => 'form-control',
		// 		'placeholder' => 'Name...'
		// 		]
		// 	]);
		$form->add('name');
		$form->add('surname');
		$form->add('description');
		$form->add('save', 'submit');

		// zwracamy formularz
		return $form->getForm();
	}

	// Formularz edycji
	private function getEditForm($contact)
	{
		// mechanizm do tworzenia formularzy
		$form = $this->createFormBuilder($contact);
		// akcja
		$form->setAction($this->generateUrl('coderslab_contact_update', ['id'=>$contact->getId()]));
		// dodajemy pola
		$form->add('name');
		$form->add('surname');
		$form->add('description');
		$form->add('update', 'submit');
		
		// zwracamy formularz
		return $form->getForm();
	}

}
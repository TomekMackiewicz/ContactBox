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
		$contact = new Contact();
		$form = $this->getNewForm($contact);
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
		$form->handleRequest($req); 

		if($form->isSubmitted()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($contact);
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
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('CodersLabBundle:Contact');
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
		$em = $this->getDoctrine()->getManager();
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
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('CodersLabBundle:Contact');
		$contact = $repo->find($id);		
		$form = $this->getEditForm($contact);
		$form->handleRequest($req); 

		if($form->isSubmitted()) {
			$em = $this->getDoctrine()->getManager();
			$em->flush($contact);
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
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('CodersLabBundle:Contact');
		$contact = $repo->find($id);	
		$em->remove($contact);
		$em->flush($contact);	
		return $this->redirectToRoute('coderslab_contact_index');
	}

	// -----------------------------------------
	//
	//    Forms
	//
	// -----------------------------------------

	private function getNewForm($contact)
	{
		$form = $this->createFormBuilder($contact);
		$form->setAction($this->generateUrl('coderslab_contact_create'));
		$form->add('name');
		$form->add('surname');
		$form->add('description');
		$form->add('save', 'submit');

		return $form->getForm();
	}

	private function getEditForm($contact)
	{
		$form = $this->createFormBuilder($contact);
		$form->setAction($this->generateUrl('coderslab_contact_update', ['id'=>$contact->getId()]));
		$form->add('name');
		$form->add('surname');
		$form->add('description');
		$form->add('update', 'submit');
		
		return $form->getForm();
	}

}
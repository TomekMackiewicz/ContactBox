<?php

namespace CodersLabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use CodersLabBundle\Entity\Email;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
* @Route("/email")
*/
class EmailController extends Controller
{

	// -----------------------------------------
	//
	//    Show all emails
	//
	// -----------------------------------------

	/**
	* @Route("/showEmails")	
	* @Method("GET")
	* @Template()
	*/
	public function showEmailsAction()
	{
		$repo = $this->getDoctrine()->getManager()->getRepository('CodersLabBundle:Email');
		$emails = $repo->findAll();

		return ['emails' => $emails];
	}

	// -----------------------------------------
	//
	//    Add email
	//
	// -----------------------------------------

	/**
	* @Route("/newEmail")
	* @Method("GET")
	* @Template()
	*/
	public function newEmailAction()
	{
		// Konstruujemy formularz, potrzebujemy danych
		$email = new Email();
		// Wywołujemy metodę budującą szablon formularza
		$form = $this->getNewEmailForm($email);
		// musi być createView()
		return ['form' => $form->createView()];
	}

	/**
	* @Route("/newEmail")
	* @Method("POST")
	* @Template()
	*/
	public function createEmailAction(Request $req)
	{
		$email = new Email();

		$form = $this->getNewEmailForm($email);

		// Obsługujemy dane przychodzace z formularza
		// Email zostaje ustawiony (nie potrzebujemy robić set dla każdej wartości)
		$form->handleRequest($req); 

		// Można jeszcze dodać isValid()
		if($form->isSubmitted()) {
			// Manager encji
			$em = $this->getDoctrine()->getManager();
			// Chcemy dodać...
			$em->persist($email);
			// Dodajemy...
			// Flush może być bez parametru, wtedy wszystkie obiekty (wszystie zmiany)
			$em->flush();
		}
		return $this->redirectToRoute('coderslab_contact_index');
	}

	// -----------------------------------------
	//
	//    Edit emails
	//
	// -----------------------------------------

	/**
	* @Route("/{id}/modifyemail")
	* @Method("GET")
	* @Template()
	*/
	public function editEmailAction($id)
	{
		// Inny zapis tego samego, co w create i delete
		$email = $this
			->getDoctrine()
			->getManager()
			->getRepository('CodersLabBundle:Email')
			->find($id);
			$form = $this->getEditEmailForm($email);
		return ['form' => $form->createView()];
	}

	/**
	* @Route("/{id}/modifyemail")
	* @Method("POST")
	*/
	public function updateEmailAction(Request $req, $id)
	{
		// Manager encji
		$em = $this->getDoctrine()->getManager();
		// Bierzemy repozytorium encji
		$repo = $em->getRepository('CodersLabBundle:Email');
		$email = $repo->find($id);		

		$form = $this->getEditEmailForm($email);

		// Obsługujemy dane przychodzace z formularza
		// Contact zostaje ustawiony (nie potrzebujemy robić set dla każdej wartości)
		$form->handleRequest($req); 

		// Można jeszcze dodać isValid()
		if($form->isSubmitted()) {
			// Manager encji
			$em = $this->getDoctrine()->getManager();
			// Dodajemy (przy update bez persist)...
			// Flush może być bez parametru, wtedy wszystkie obiekty (wszystie zmiany)
			$em->flush($email);
			// Albo krócej:
			// $this->getDoctrine()->getManager()->flush($contact);
		}
		return $this->redirectToRoute('coderslab_email_showemails');
	}

	// -----------------------------------------
	//
	//    Delete email
	//
	// -----------------------------------------

	/**
	* @Route("/{id}/deleteemail")
	* @Method("GET")
	*/
	public function deleteEmailAction($id)
	{
		// Manager encji
		$em = $this->getDoctrine()->getManager();
		// Bierzemy repozytorium encji
		$repo = $em->getRepository('CodersLabBundle:Email');
		$email = $repo->find($id);
		// Chcemy usunąć...	
		$em->remove($email);
		// Usuwamy...
		$em->flush($email);	
		return $this->redirectToRoute('coderslab_email_showemails');
	}

	// -----------------------------------------
	//
	//    Forms
	//
	// -----------------------------------------

	// Formularz zapisu
	private function getNewEmailForm($email)
	{
		// mechanizm do tworzenia formularzy
		$form = $this->createFormBuilder($email);
		// akcja
		$form->setAction($this->generateUrl('coderslab_email_createemail'));
		$form->add('email');
		$form->add('user_id');	
		$form->add('save', 'submit');
		
		// zwracamy formularz
		return $form->getForm();
	}

	// Formularz edycji
	private function getEditEmailForm($email)
	{
		// mechanizm do tworzenia formularzy
		$form = $this->createFormBuilder($email);
		// akcja
		$form->setAction($this->generateUrl('coderslab_email_updateemail', ['id'=>$email->getId()]));
		// dodajemy pola
		$form->add('email');
		$form->add('update', 'submit');
		
		// zwracamy formularz
		return $form->getForm();
	}

}
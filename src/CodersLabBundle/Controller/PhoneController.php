<?php

namespace CodersLabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use CodersLabBundle\Entity\Phone;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
* @Route("/phone")
*/
class PhoneController extends Controller
{

	// -----------------------------------------
	//
	//    Show all phones
	//
	// -----------------------------------------

	/**
	* @Route("/showPhones")	
	* @Method("GET")
	* @Template()
	*/
	public function showPhonesAction()
	{
		$repo = $this->getDoctrine()->getManager()->getRepository('CodersLabBundle:Phone');
		$phones = $repo->findAll();

		return ['phones' => $phones];
	}

	// -----------------------------------------
	//
	//    Add phone
	//
	// -----------------------------------------

	/**
	* @Route("/newPhone")
	* @Method("GET")
	* @Template()
	*/
	public function newPhoneAction()
	{
		// Konstruujemy formularz, potrzebujemy danych
		$phone = new Phone();
		// Wywołujemy metodę budującą szablon formularza
		$form = $this->getNewPhoneForm($phone);
		// musi być createView()
		return ['form' => $form->createView()];
	}

	/**
	* @Route("/newPhone")
	* @Method("POST")
	* @Template()
	*/
	public function createPhoneAction(Request $req)
	{
		$phone = new Phone();

		$form = $this->getNewPhoneForm($phone);

		// Obsługujemy dane przychodzace z formularza
		// Phone zostaje ustawiony (nie potrzebujemy robić set dla każdej wartości)
		$form->handleRequest($req); 

		// Można jeszcze dodać isValid()
		if($form->isSubmitted()) {
			// Manager encji
			$em = $this->getDoctrine()->getManager();
			// Chcemy dodać...
			$em->persist($phone);
			// Dodajemy...
			// Flush może być bez parametru, wtedy wszystkie obiekty (wszystie zmiany)
			$em->flush();
		}
		return $this->redirectToRoute('coderslab_contact_index');
	}

	// -----------------------------------------
	//
	//    Edit phones
	//
	// -----------------------------------------

	/**
	* @Route("/{id}/modifyphone")
	* @Method("GET")
	* @Template()
	*/
	public function editPhoneAction($id)
	{
		// Inny zapis tego samego, co w create i delete
		$phone = $this
			->getDoctrine()
			->getManager()
			->getRepository('CodersLabBundle:Phone')
			->find($id);
			$form = $this->getEditPhoneForm($phone);
		return ['form' => $form->createView()];
	}

	/**
	* @Route("/{id}/modifyphone")
	* @Method("POST")
	*/
	public function updatePhoneAction(Request $req, $id)
	{
		// Manager encji
		$em = $this->getDoctrine()->getManager();
		// Bierzemy repozytorium encji
		$repo = $em->getRepository('CodersLabBundle:Phone');
		$phone = $repo->find($id);		

		$form = $this->getEditPhoneForm($phone);

		// Obsługujemy dane przychodzace z formularza
		// Contact zostaje ustawiony (nie potrzebujemy robić set dla każdej wartości)
		$form->handleRequest($req); 

		// Można jeszcze dodać isValid()
		if($form->isSubmitted()) {
			// Manager encji
			$em = $this->getDoctrine()->getManager();
			// Dodajemy (przy update bez persist)...
			// Flush może być bez parametru, wtedy wszystkie obiekty (wszystie zmiany)
			$em->flush($phone);
			// Albo krócej:
			// $this->getDoctrine()->getManager()->flush($contact);
		}
		return $this->redirectToRoute('coderslab_phone_showphones');
	}

	// -----------------------------------------
	//
	//    Delete phone
	//
	// -----------------------------------------

	/**
	* @Route("/{id}/deletephone")
	* @Method("GET")
	*/
	public function deletePhoneAction($id)
	{
		// Manager encji
		$em = $this->getDoctrine()->getManager();
		// Bierzemy repozytorium encji
		$repo = $em->getRepository('CodersLabBundle:Phone');
		$phone = $repo->find($id);
		// Chcemy usunąć...	
		$em->remove($phone);
		// Usuwamy...
		$em->flush($phone);	
		return $this->redirectToRoute('coderslab_phone_showphones');
	}

	// -----------------------------------------
	//
	//    Forms
	//
	// -----------------------------------------

	// Formularz zapisu
	private function getNewPhoneForm($phone)
	{
		// mechanizm do tworzenia formularzy
		$form = $this->createFormBuilder($phone);
		// akcja
		$form->setAction($this->generateUrl('coderslab_phone_createphone'));
		$form->add('phone');
		$form->add('user_id');	
		$form->add('save', 'submit');
		
		// zwracamy formularz
		return $form->getForm();
	}

	// Formularz edycji
	private function getEditPhoneForm($phone)
	{
		// mechanizm do tworzenia formularzy
		$form = $this->createFormBuilder($phone);
		// akcja
		$form->setAction($this->generateUrl('coderslab_phone_updatephone', ['id'=>$phone->getId()]));
		// dodajemy pola
		$form->add('phone');
		$form->add('update', 'submit');
		
		// zwracamy formularz
		return $form->getForm();
	}

}
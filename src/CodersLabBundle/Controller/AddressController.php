<?php

namespace CodersLabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use CodersLabBundle\Entity\Address;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
* @Route("/address")
*/
class AddressController extends Controller
{

	// -----------------------------------------
	//
	//    Show all addresses
	//
	// -----------------------------------------

	/**
	* @Route("/showAddresses")
	* @Method("GET")
	* @Template()
	*/
	public function showAddressesAction()
	{
		$repo = $this->getDoctrine()->getManager()->getRepository('CodersLabBundle:Address');
		$addresses = $repo->findAll();

		return ['addresses' => $addresses];
	}

	// -----------------------------------------
	//
	//    Add address
	//
	// -----------------------------------------

	/**
	* @Route("/newAddress")
	* @Method("GET")
	* @Template()
	*/
	public function newAddressAction()
	{
		// Konstruujemy formularz, potrzebujemy danych
		$address = new Address();
		// Wywołujemy metodę budującą szablon formularza
		$form = $this->getNewAddressForm($address);
		// musi być createView()
		return ['form' => $form->createView()];
	}

	/**
	* @Route("/newAddress")
	* @Method("POST")
	* @Template()
	*/
	public function createAddressAction(Request $req)
	{
		$address = new Address();

		$form = $this->getNewAddressForm($address);

		// Obsługujemy dane przychodzace z formularza
		// Address zostaje ustawiony (nie potrzebujemy robić set dla każdej wartości)
		$form->handleRequest($req); 

		// Można jeszcze dodać isValid()
		if($form->isSubmitted()) {
			// Manager encji
			$em = $this->getDoctrine()->getManager();
			// Chcemy dodać...
			$em->persist($address);
			// Dodajemy...
			// Flush może być bez parametru, wtedy wszystkie obiekty (wszystie zmiany)
			$em->flush();
		}
		return $this->redirectToRoute('coderslab_contact_index');
	}

	// -----------------------------------------
	//
	//    Edit address
	//
	// -----------------------------------------

	/**
	* @Route("/{id}/modifyaddress")
	* @Method("GET")
	* @Template()
	*/
	public function editAddressAction($id)
	{
		// Inny zapis tego samego, co w create i delete
		$address = $this
			->getDoctrine()
			->getManager()
			->getRepository('CodersLabBundle:Address')
			->find($id);
			$form = $this->getEditAddressForm($address);
		return ['form' => $form->createView()];
	}

	/**
	* @Route("/{id}/modifyaddress")
	* @Method("POST")
	*/
	public function updateAddressAction(Request $req, $id)
	{
		// Manager encji
		$em = $this->getDoctrine()->getManager();
		// Bierzemy repozytorium encji
		$repo = $em->getRepository('CodersLabBundle:Address');
		$address = $repo->find($id);		

		$form = $this->getEditAddressForm($address);

		// Obsługujemy dane przychodzace z formularza
		// Contact zostaje ustawiony (nie potrzebujemy robić set dla każdej wartości)
		$form->handleRequest($req); 

		// Można jeszcze dodać isValid()
		if($form->isSubmitted()) {
			// Manager encji
			$em = $this->getDoctrine()->getManager();
			// Dodajemy (przy update bez persist)...
			// Flush może być bez parametru, wtedy wszystkie obiekty (wszystie zmiany)
			$em->flush($address);
			// Albo krócej:
			// $this->getDoctrine()->getManager()->flush($contact);
		}
		return $this->redirectToRoute('coderslab_address_showaddresses');
	}

	// -----------------------------------------
	//
	//    Delete address
	//
	// -----------------------------------------

	/**
	* @Route("/{id}/deleteaddress")
	* @Method("GET")
	*/
	public function deleteAddressAction($id)
	{
		// Manager encji
		$em = $this->getDoctrine()->getManager();
		// Bierzemy repozytorium encji
		$repo = $em->getRepository('CodersLabBundle:Address');
		$address = $repo->find($id);
		// Chcemy usunąć...	
		$em->remove($address);
		// Usuwamy...
		$em->flush($address);	
		return $this->redirectToRoute('coderslab_address_showaddresses');
	}

	// -----------------------------------------
	//
	//    Forms
	//
	// -----------------------------------------

	// Formularz zapisu
	private function getNewAddressForm($address)
	{
		// mechanizm do tworzenia formularzy
		$form = $this->createFormBuilder($address);
		// akcja
		$form->setAction($this->generateUrl('coderslab_address_createaddress'));
		$form->add('fullAddress');
		$form->add('user_id');	
		$form->add('save', 'submit');
		
		// zwracamy formularz
		return $form->getForm();
	}

	// Formularz edycji
	private function getEditAddressForm($address)
	{
		// mechanizm do tworzenia formularzy
		$form = $this->createFormBuilder($address);
		// akcja
		$form->setAction($this->generateUrl('coderslab_address_updateaddress', ['id'=>$address->getId()]));
		// dodajemy pola
		$form->add('fullAddress');
		$form->add('update', 'submit');
		
		// zwracamy formularz
		return $form->getForm();
	}

}
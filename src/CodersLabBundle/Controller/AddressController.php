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
		$address = new Address();
		$form = $this->getNewAddressForm($address);
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
		$form->handleRequest($req); 

		if($form->isSubmitted()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($address);
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
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('CodersLabBundle:Address');
		$address = $repo->find($id);		
		$form = $this->getEditAddressForm($address);
		$form->handleRequest($req); 

		if($form->isSubmitted()) {
			$em = $this->getDoctrine()->getManager();
			$em->flush($address);
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
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('CodersLabBundle:Address');
		$address = $repo->find($id);	
		$em->remove($address);
		$em->flush($address);	
		return $this->redirectToRoute('coderslab_address_showaddresses');
	}

	// -----------------------------------------
	//
	//    Forms
	//
	// -----------------------------------------

	private function getNewAddressForm($address)
	{
		$form = $this->createFormBuilder($address);
		$form->setAction($this->generateUrl('coderslab_address_createaddress'));
		$form->add('fullAddress');
		$form->add('user_id');	
		$form->add('save', 'submit');
		return $form->getForm();
	}

	private function getEditAddressForm($address)
	{
		$form = $this->createFormBuilder($address);
		$form->setAction($this->generateUrl('coderslab_address_updateaddress', ['id'=>$address->getId()]));
		$form->add('fullAddress');
		$form->add('update', 'submit');
		return $form->getForm();
	}

}
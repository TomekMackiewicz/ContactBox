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
		$phone = new Phone();
		$form = $this->getNewPhoneForm($phone);
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
		$form->handleRequest($req); 

		if($form->isSubmitted()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($phone);
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
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('CodersLabBundle:Phone');
		$phone = $repo->find($id);		
		$form = $this->getEditPhoneForm($phone);
		$form->handleRequest($req); 

		if($form->isSubmitted()) {
			$em = $this->getDoctrine()->getManager();
			$em->flush($phone);
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
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('CodersLabBundle:Phone');
		$phone = $repo->find($id);	
		$em->remove($phone);
		$em->flush($phone);	
		return $this->redirectToRoute('coderslab_contact_index');
	}

	// -----------------------------------------
	//
	//    Forms
	//
	// -----------------------------------------

	private function getNewPhoneForm($phone)
	{
		$form = $this->createFormBuilder($phone);
		$form->setAction($this->generateUrl('coderslab_phone_createphone'));
		$form->add('phone');
		$form->add('contact_id');	
		$form->add('save', 'submit');
		
		return $form->getForm();
	}

	private function getEditPhoneForm($phone)
	{
		$form = $this->createFormBuilder($phone);
		$form->setAction($this->generateUrl('coderslab_phone_updatephone', ['id'=>$phone->getId()]));
		$form->add('phone');
		$form->add('update', 'submit');
		
		return $form->getForm();
	}

}
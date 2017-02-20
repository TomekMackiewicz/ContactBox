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
		$email = new Email();
		$form = $this->getNewEmailForm($email);
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
		$form->handleRequest($req); 

		if($form->isSubmitted()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($email);
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
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('CodersLabBundle:Email');
		$email = $repo->find($id);		
		$form = $this->getEditEmailForm($email);
		$form->handleRequest($req); 

		if($form->isSubmitted()) {
			$em = $this->getDoctrine()->getManager();
			$em->flush($email);
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
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('CodersLabBundle:Email');
		$email = $repo->find($id);	
		$em->remove($email);
		$em->flush($email);	
		return $this->redirectToRoute('coderslab_email_showemails');
	}

	// -----------------------------------------
	//
	//    Forms
	//
	// -----------------------------------------

	private function getNewEmailForm($email)
	{
		$form = $this->createFormBuilder($email);
		$form->setAction($this->generateUrl('coderslab_email_createemail'));
		$form->add('email');
		$form->add('user_id');	
		$form->add('save', 'submit');
		
		return $form->getForm();
	}

	private function getEditEmailForm($email)
	{
		$form = $this->createFormBuilder($email);
		$form->setAction($this->generateUrl('coderslab_email_updateemail', ['id'=>$email->getId()]));
		$form->add('email');
		$form->add('update', 'submit');
		
		return $form->getForm();
	}

}
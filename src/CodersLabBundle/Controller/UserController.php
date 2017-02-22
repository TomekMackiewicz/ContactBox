<?php

namespace CodersLabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use CodersLabBundle\Entity\User;

class UserController extends Controller
{

	/**
	* @Route("/")
	*/
	public function redirectToLogin()
	{
		return $this->redirect('/login');
	}

}
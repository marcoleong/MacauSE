<?php

namespace MacauSE\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/admin_dashboard")
 */
class AdminController extends Controller
{
	
	/**
	 * @Route("/")
	 * @Secure(roles="ROLE_ADMIN")
	 */
	public function indexAction(Request $request){
		
	}
}

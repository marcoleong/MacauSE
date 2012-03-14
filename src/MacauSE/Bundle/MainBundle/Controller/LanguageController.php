<?php

namespace MacauSE\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

class LanguageController extends Controller{
	/**
	 * @Route("/lang_switch/{locale}", name="macause_language_switch", requirements={"locale" = "(en|pt|zh)"})
	 * @Method({"get"})
	 */
	public function changeLanguageAction($locale)
	{
		$request = $this->getRequest();
		$session = $request->getSession();
		$currentLocale = $session->get('_locale');
		$session->set('_locale',$locale);
		// var_dump($request->getBaseUrl());
		$redirectTo = null;
		$prevUrl = $request->server->get('HTTP_REFERER');
		
		$redirectTo = str_replace('/'.$currentLocale.'/','/'.$locale.'/',$prevUrl);
		return $this->redirect($redirectTo);
	}
}

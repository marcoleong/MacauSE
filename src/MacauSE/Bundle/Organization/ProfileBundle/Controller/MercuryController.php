<?php

namespace MacauSE\Bundle\Organization\ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;


use MacauSE\Bundle\Organization\ProfileBundle\Document\Profile;

/**
 * @Route("/mercury")
 */
class MercuryController extends Controller
{
    /**
     * @Route("/update/",name="mercury_editor_update", options={"expose"=true}, requirements={"_format"="(xml|json)"})
	 * @Method({"POST"})
     */
    public function updateAction()
    {
		$request = $this->getRequest();
		$session = $request->getSession();
		$dm = $this->get('doctrine.odm.mongodb.document_manager');
		$profile = $dm->getRepository('MacauSEOrganizationProfileBundle:Profile')->findOneBy(array('slug' => $session->get('slug')));

		$json = json_decode($request->request->get('content'),true);
		
		foreach($json as $key=>$value){
			//safety measure
			if(method_exists($profile,'set'.ucfirst($key))){
				//calling set function for different field
				call_user_func(array($profile, 'set'.ucfirst($key)),$value['value']);
			}else{
				throw new Exception('The function does not exist, most probably this field does not exist.');
			}
		}
		
		$dm->persist($profile);
		$dm->flush();
		
        return new Response('',200);
    }


}

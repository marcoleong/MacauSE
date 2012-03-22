<?php

namespace MarcoLeong\Bundle\MercuryEditorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class EditorController extends Controller
{
    /**
     * @Route("/mercury_editor/save/{slug}", name="marcoleong_mercury_editor_save",options={"expose"=true}) 
	 * @Secure(roles="ROLE_ADMIN")
     */
    public function saveAction(Request $request, $slug)
    {
		$locale = $request->attributes->get('_locale');
		
		if($request->isXmlHttpRequest()){
			$dm =  $this->get('doctrine.odm.mongodb.document_manager'); 
	    	$profile = $dm->getRepository('MacauSEDirectoryBundle:Profile')->findOneBy(array('slug' => $slug));
			$profile->setLocale($locale);
			$dm->refresh($profile);
			if(!$profile){
		        throw $this->createNotFoundException('No organization found.');
			}
			
			$json_data = $request->request->get('content');
			
			$data = json_decode($json_data,true);
			foreach ($data as $field=>$value){
				call_user_func(array($profile, 'set'.ucfirst($field)),$value['value']);
			}	

			$dm->persist($profile);
			$dm->flush();

		}
        return new Response("Saved !",200);
    }
}

<?php

namespace MacauSE\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;


class WebController extends Controller
{
    /**
     * @Route("/",name="macause_homepage")
     * @Template("MacauSEWebBundle:Default:index.html.twig")
     */
    public function indexAction()
    {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        return array('tags' => '');
    }

    /**
     * @Route("/search",name="macause_web_search")
     * @Method({ "head", "get" })
     * @Template("MacauSEWebBundle:Default:search.html.twig")
     */
    public function searchAction(Request $request)
    {
    	$search = $request->query->get('q');
    	$profileType = $this->container->get('foq_elastica.index.website.profile');
    	$resultSet = $profileType->search($search);
        if($resultSet->count()<1){
            $this->get('session')->setFlash('notice', 'No results was found!');
        }
        return array('results' => $resultSet);
    }

	/**
	 * @Route("/language_switch", name="macause_web_language_switch")
	 * @Method({"GET"})
	 */
	public function languageSwitchAction(Request $request)
	{
		$to_locale = $request->query->get('_locale');
		$profile_slug = $request->query->get('slug');
		$fallback_route = $request->query->get('fallback_route') != null ? $request->query->get('fallback_route') : 'macause_homepage' ;
		
		$dm =  $this->get('doctrine.odm.mongodb.document_manager');
		//in directory page, if user is admin, create new translation, else if
		if($fallback_route == "organization_profile_show"){
			if($this->get('security.context')->isGranted('ROLE_ADMIN')){
				//check if it have the locale.
				$current_profile = $dm->getRepository('MacauSEDirectoryBundle:Profile')->findOneBy(array('slug' => $profile_slug));
		    	$profile = $dm->getRepository('MacauSEDirectoryBundle:Profile')->findOneBy(array('slug' => $profile_slug, 'locale' => $to_locale));
				if(!$profile){
					// create new translation
					$current_profile->setTranslatableLocale($to_locale);
					$dm->persist($current_profile);
					$dm->flush();
					$redirect_url = $this->generateUrl($fallback_route, array('slug' => $profile_slug, '_locale' => $to_locale));
				}else{
					// redirect to exist tranlation
					$redirect_url = $this->generateUrl($fallback_route, array('slug' => $profile->getSlug(), '_locale' => $to_locale));
				}
			}
		}else{
			$redirect_url = $this->generateUrl($fallback_route, array('_locale' => $to_locale));
		}
		return $this->redirect($redirect_url);
	}
	
	private function getValueInArray($arr, $key){
		return $arr[$key];
	}
}

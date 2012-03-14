<?php

namespace MacauSE\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;


class MainController extends Controller
{
    /**
     * @Route("/",name="macause_homepage")
     * @Template("MacauSEMainBundle:Default:index.html.twig")
     */
    public function indexAction()
    {
    	//return tags and count.
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $tags = $dm->createQueryBuilder('MacauSEOrganizationProfileBundle:Tag')->find();

        return array('tags' => '');
    }

    /**
     * @Route("/search",name="macause_main_search")
     * @Method({ "head", "get" })
     * @Template("MacauSEMainBundle:Default:search.html.twig")
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
     * @Route("/search_autocomplete",name="macause_main_search_autocomplete")
     * @Method({ "head", "get" })
     */
    public function searchAutoCompleteAction(Request $request)
    {
        $sm = $this->get('foq_elastica.finder.manager');
        $resultSet = $sm->getRepository('MacauSEMainBundle:Main')->findByPartialName($request->query->get('p'));
        return array('results' => $resultSet);
    }

}

<?php

namespace MacauSE\Bundle\Organization\ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use MacauSE\Bundle\Organization\ProfileBundle\Document\Profile;

class ProfileController extends Controller
{

    /**
     * @Route("/profile/{slug}",name="organization_profile_show")
     * @Template("MacauSEOrganizationProfileBundle:Profile:show.html.twig")
     */
    public function showAction($slug)
    {
    	$profile = $this->get('doctrine.odm.mongodb.document_manager')
        ->getRepository('MacauSEOrganizationProfileBundle:Profile')
        ->findOneBy(array('slug' => $slug));

        if (!$profile) {
	        throw $this->createNotFoundException('No organization found for slug '.$slug);
	    }
		$isAuthenticated = true;
		$this->getRequest()->getSession() ->set('slug',$slug);
    	return array('profile'=>$profile, 'isAuthenticated' => $isAuthenticated);
    }

    

    /**
     * @Route("/edit/{slug}")
     * @Template("MacauSEOrganizationProfileBundle:Profile:edit.html.twig")
     */
    public function editAction($slug)
    {
    	$profile = $this->get('doctrine.odm.mongodb.document_manager')
        ->getRepository('MacauSEOrganizationProfileBundle:Profile')
        ->findBy(array('slug'=>$slug));

        if (!$profile) {
	        throw $this->createNotFoundException('No product found for id '.$id);
	    }
    	// $form = $this->createFormBuilder($profile)
     //        ->add('name', 'text')
     //        ->add('slug', 'text')
     //        ->getForm();
        return array('organization_name' => '');
    }

    /**
     * @Route("/create/",name="organization_profile_create")
     * @Template("MacauSEOrganizationProfileBundle:Profile:create.html.twig")
     */
    public function createAction()
    {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $tags = $dm->getRepository('MacauSEOrganizationProfileBundle:Tag')->findAll();
    	$request = $this->getRequest();
    	$profile = new Profile();
    	$form = $this->createFormBuilder($profile)
            ->add('name', 'text')
            // ->add('description', 'textarea')
            // ->add('services', 'textarea')
            // ->add('contact','textarea')
            ->getForm();

        if ($request->getMethod() == 'POST') {
	        $form->bindRequest($request);

	        if ($form->isValid()) {
	            // perform some action, such as saving the task to the database
	            $dm->persist($profile);
	            $dm->flush();
	            return $this->redirect($this->generateUrl('organization_profile_show', array('slug' => $profile->getSlug())));
	        }
	    }
    	return array('form'=>$form->createView());
    }

    /**
     * @Route("/directory/",name="organization_profile_directory")
     * @Template("MacauSEOrganizationProfileBundle:Profile:index.html.twig")
     */
    public function indexAction()
    {
        $profiles = $this->get('doctrine.odm.mongodb.document_manager')
        ->getRepository('MacauSEOrganizationProfileBundle:Profile')
        ->findAll();


        if (!$profiles) {
            throw $this->createNotFoundException('No organization found for slug '.$slug);
        }

        return array('profiles'=>$profiles);
    }
}

<?php

namespace MacauSE\Bundle\Organization\ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use MacauSE\Bundle\Organization\ProfileBundle\Document\Profile;
use MacauSE\Bundle\Organization\ProfileBundle\Document\Tag;
use MacauSE\Bundle\Organization\ProfileBundle\Form\Type\ProfileType;

/**
 * @Route("/{_locale}", requirements={"_locale" = "(en|fr|de)"})
 */
class ProfileController extends Controller
{

	public function getExistTags(){
		$dm =  $this->get('doctrine.odm.mongodb.document_manager');
		
		$tags = $dm->getRepository('MacauSEOrganizationProfileBundle:Tag')->findAll();
		$arr = array();
		foreach($tags as $tag){
			$arr[] = $tag->getName();
		}
		return $arr;
	}
    /**
     * @Route("/show/{slug}",name="organization_profile_show")
     * @Template("MacauSEOrganizationProfileBundle:Profile:show.html.twig")
     */
    public function showAction($slug)
    {	
		$dm =  $this->get('doctrine.odm.mongodb.document_manager');
		$request = $this->getRequest();
    	$profile = $dm->getRepository('MacauSEOrganizationProfileBundle:Profile')->findOneBy(array('slug' => $slug));
		$existTags = $this->getExistTags();
        if (!$profile) {
	        throw $this->createNotFoundException('No organization found.');
	    }
		$options = null;
		if (true === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
			//option to turn off mercury
			$options = array('mercury' => $request->query->get('mercury') );
			$form = $this->createForm(new ProfileType(), $profile);
			$form_view = $form->createView();
			
			if ($request->getMethod() == 'POST') {
				// $form->bindRequest($request);
				$tags = $request->request->get('tags');
				$profile->removeAllTags();
				
				if(!is_null($tags)){
					foreach($tags['tags'] as $tagName){
						$tagObj = null;
						if(in_array($tagName,$existTags)){
							$tagObj = $dm->getRepository('MacauSEOrganizationProfileBundle:Tag')->findOneBy(array('name'=> $tagName));
						}else{
							$tagObj = new Tag();
							$tagObj->setName($tagName);
							$dm->persist($tagObj);
						}	
						$profile->addTags($tagObj);
					}
				}
				
				$dm->persist($profile);
				$dm->flush();

		        return $this->redirect($this->generateUrl('organization_profile_show', array('slug' => $profile->getSlug())));
				
			
			}
		}else{
			$form_view = null;
		}
		
		$this->getRequest()->getSession()->set('slug',$slug);
    	return array('profile'=>$profile,'form'=>$form_view,'options'=>$options);
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
    	$request = $this->getRequest();
    	$profile = new Profile();
    	$form = $this->createFormBuilder($profile)
            ->add('name', 'text')
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

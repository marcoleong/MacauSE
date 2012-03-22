<?php

namespace MacauSE\DirectoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use MacauSE\DirectoryBundle\Document\Profile;
use MacauSE\DirectoryBundle\Document\Tag;
use MacauSE\DirectoryBundle\Form\Type\ProfileType;

use Symfony\Component\HttpFoundation\Request;


class ProfileController extends Controller
{

	public function getExistTags(){
		$dm =  $this->get('doctrine.odm.mongodb.document_manager');
		$tags = $dm->getRepository('MacauSEDirectoryBundle:Tag')->findAll();
		$arr = array();
		foreach($tags as $tag){
			$arr[] = $tag->getName();
		}
		return $arr;
	}
    /**
     * @Route("/show/{slug}",name="organization_profile_show")
     * @Template("MacauSEDirectoryBundle:Profile:show.html.twig")
     */
    public function showAction(Request $request, $slug)
    {
		$dm =  $this->get('doctrine.odm.mongodb.document_manager');
		// $dm->getRepository('GedmoTranslatable'); 
    	$profile = $dm->getRepository('MacauSEDirectoryBundle:Profile')->findOneBy(array('slug' => $slug));
		$profile->setLocale($request->attributes->get('_locale'));
		$dm->refresh($profile);
		
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
							$tagObj = $dm->getRepository('MacauSEDirectoryBundle:Tag')->findOneBy(array('name'=> $tagName));
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
		
		// $this->getRequest()->getSession()->set('slug',$slug);
    	return array('profile'=>$profile,'form'=>$form_view,'options'=>$options);
    }

    

    /**
     * @Route("/edit/{slug}")
     * @Template("MacauSEDirectoryBundle:Profile:edit.html.twig")
     */
    public function editAction(Request $request, $slug)
    {
    	$profile = $this->get('doctrine.odm.mongodb.document_manager')
        ->getRepository('MacauSEDirectoryBundle:Profile')
        ->findBy(array('slug'=>$slug, 'locale' => $request->attributes->get('_locale')));

        if (!$profile) {
	        throw $this->createNotFoundException('No product found for id '.$id);
	    }
        return array('organization_name' => '');
    }

    /**
     * @Route("/create/",name="organization_profile_create")
     * @Template("MacauSEDirectoryBundle:Profile:create.html.twig")
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
				$locale = $request->attributes->get('_locale');
		
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
     * @Template("MacauSEDirectoryBundle:Profile:index.html.twig")
     */
    public function indexAction(Request $request)
    {
		$dm = $this->get('doctrine.odm.mongodb.document_manager');
        $profiles = $dm->createQueryBuilder('MacauSEDirectoryBundle:Profile')->getQuery()->execute();
        if ($profiles->count() <= 0) {
	        $this->get('session')->setFlash('notice', 'No results was found!');
            // throw $this->createNotFoundException('No organization found');
        }

        return array('profiles'=>$profiles);
    }



}

<?php

namespace MacauSE\Bundle\Organization\ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use MacauSE\Bundle\Organization\ProfileBundle\Document\Profile;
use MacauSE\Bundle\Organization\ProfileBundle\Document\Tag;
use MacauSE\Bundle\Organization\ProfileBundle\Form\Type\ProfileType;
class ProfileController extends Controller
{

    /**
     * @Route("/show/{slug}",name="organization_profile_show")
     * @Template("MacauSEOrganizationProfileBundle:Profile:show.html.twig")
     */
    public function showAction($slug)
    {
		$dm =  $this->get('doctrine.odm.mongodb.document_manager');
		$request = $this->getRequest();
    	$profile = $dm->getRepository('MacauSEOrganizationProfileBundle:Profile')->findOneBy(array('slug' => $slug));

		// $tag1 = new Tag();
		// $tag1->setName('Hello0');
		// $tag2 = new Tag();
		// $tag2->setName('Hello1');
		// $tag3 = new Tag();
		// $tag3->setName('Hello2');
		// $profile->addTags($tag1);
		// $profile->addTags($tag2);
		// $profile->addTags($tag3);
		
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
				//$form->bindRequest($request);
				$tags = $request->request->get('tags');
			
				foreach($tags as $tag){
					try{
						$newTag = new Tag();
						$newTag->setName($tag);
						$profile->addTags($newTag);
					}catch(Exception $e){
						echo $e;
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

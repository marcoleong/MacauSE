<?php

namespace MacauSE\Bundle\Organization\ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use MacauSE\Bundle\Organization\ProfileBundle\Document\Profile;
use Symfony\Component\HttpFoundation\Response;

use MacauSE\Bundle\Organization\ProfileBundle\Form\Type\TagType;

/**
 * This controller work with the Tagedit
 */
class TagController extends Controller
{
	public function autoCompleteAction(){
		//TODO: Retrieve list of tag exist.
	}
	
	/**
	 * @Route("/profile/tag/update",name="profile_tag_form")
	 * @Template("MacauSEOrganizationProfileBundle:Form:form_tag_field.html.twig")
	 */
	public function renderFormAction(){
		//TODO
		// CSRF safety with built-in protection.
		$request = $this->getRequest();
		$session = $request->getSession();

		$tags = $this->get('doctrine.odm.mongodb.document_manager')
        ->getRepository('MacauSEOrganizationProfileBundle:Tag')
        ->findAll();
		$form = $this->createForm(new TagType(), $tags);

		if ($request->getMethod() == 'POST') {
	        $form->bindRequest($request);
	        if ($form->isValid()) {
		            // perform some action, such as saving the task to the database
				return $this->redirect($this->generateUrl('organization_profile_show', array('slug' => $profile->getSlug())));        
	        }
	    }
		return array('form' => $form->createView());
	}
	/**
	 * @Route("/profile/tag/save",name="profile_tag_save")
	 */
	public function saveAction(){
		$request = $this->getRequest();
		//this is an ARRAY
		$tags = $request->request->get('tag');
		
		// $showResult = false;
		// if(array_key_exists('save', $_POST) && (array_key_exists('tag', $_POST) || array_key_exists('formdata', $_POST))) {
		//     // Include the autocompleteScript to know what was in the database
		//     // include ('autocomplete.php');
		// 
		//     $result = array('new' => array(), 'deleted' => array(), 'changed' => array(), 'not changed' => array());
		//     $tags = array_key_exists('tag', $_POST)? $_POST['tag'] : $_POST['formdata']['tags'];
		//     $showResult = false;
		// 
		//     // foreach($tags as $key => $value) {
		//     // 		        if(preg_match('/([0-9]*)-?(a|d)?$/', $key, $keyparts) === 1) {
		//     // 		            $showResult = true;
		//     // 		            if(isset($keyparts[2])) {
		//     // 		                switch($keyparts[2]) {
		//     // 		                    case 'a':
		//     // 		                        if($autocompletiondata[$keyparts[1]] != $value) {
		//     // 		                            // Items has changed
		//     // 		                            $result['changed'][] = $keyparts[1] . ' (new value: "' . $value . '")';
		//     // 		                        }
		//     // 		                        else {
		//     // 		                            $result['not changed'][] = $keyparts[1] . ' ("' . $value . '")';
		//     // 		                        }
		//     // 		                        break;
		//     // 		                    case 'd':
		//     // 		                        $result['deleted'][] = $keyparts[1] . ' ("' . $value . '")';
		//     // 		                        break;
		//     // 		                }
		//     // 		            }
		//     // 		            else {
		//     // 		                $result['new'][] = $key . ' ("' . $value . '")';
		//     // 		            }
		//     // 		        }
		//     // 		    }
		// 	
		// }
		return new Response('Response',200);
	}
}

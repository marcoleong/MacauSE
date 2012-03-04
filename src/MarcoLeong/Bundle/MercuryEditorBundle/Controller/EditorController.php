<?php

namespace MarcoLeong\Bundle\MercuryEditorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class EditorController extends Controller
{
    /**
     * @Template()
     */
    public function showAction($name)
    {
        return array('name' => $name);
    }

    /**
     * @Route("/mercury_editor/save", name="marcoleong_mercury_editor_save") 
     */
    public function saveAction()
    {
        return array('name' => $name);
    }
}

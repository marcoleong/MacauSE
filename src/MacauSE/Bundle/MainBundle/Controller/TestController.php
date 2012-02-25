<?php

namespace MacauSE\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use MacauSE\Bundle\Organization\ProfileBundle\Document\Profile;

/**
 * @Route("/test")
 */
class TestController extends Controller
{

    /**
     * @Route("/slug")
     */
    public function slugAction(){
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $profile = new Profile();
        $profile->setName('Hello');
        $dm->persist($profile);
        $dm->flush();
        $dm->clear();
        echo var_dump($profile);
        return new Response('',200);
    }
}

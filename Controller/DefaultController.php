<?php

namespace Optime\Commtool\TemplateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('CommtoolTemplateBundle:Default:index.html.twig', array('name' => ''));
    }

    public function saveAction()
    {
        die;
    }

}

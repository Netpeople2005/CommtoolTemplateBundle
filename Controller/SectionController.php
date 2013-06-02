<?php

namespace Optime\Commtool\TemplateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SectionController extends Controller
{

    public function indexAction()
    {
        $sections = array(
            'singleline',
            'multiline',
            'gallery',
        );
        
        return $this->render('CommtoolTemplateBundle:Section:list.html.twig', array(
            'sections' => $sections,
        ));
    }

}
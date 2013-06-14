<?php

namespace Optime\Commtool\TemplateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Optime\Commtool\TemplateBundle\Section;

class SectionController extends Controller
{

    public function indexAction()
    {
        $sections = array(
            new Section\Singleline(),
        );
        
        return $this->render('CommtoolTemplateBundle:Section:list.html.twig', array(
            'sections' => $sections,
        ));
    }

    public function propertiesAction($type)
    {
        
        return $this->render('CommtoolTemplateBundle:Section:properties.html.twig', array(
            
        ));
    }

}
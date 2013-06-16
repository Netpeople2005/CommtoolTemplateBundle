<?php

namespace Optime\Commtool\TemplateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Optime\Commtool\TemplateBundle\Section;

class SectionController extends Controller
{

    public function indexAction()
    {
        $sections = $this->get('template_section_factory')->getSections();

        return $this->render('CommtoolTemplateBundle:Section:list.html.twig', array(
                    'sections' => $sections,
        ));
    }

    public function propertiesAction($type)
    {
        $section = $this->get('template_section_factory')->getType($type);

        return $this->render('CommtoolTemplateBundle:Section:properties.html.twig', array(
                    'section' => $section,
        ));
    }

}
<?php

namespace Optime\Commtool\TemplateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
        
        $resolver = new OptionsResolver();
        
        $section->setDefaultOptions($resolver);

        return $this->render('CommtoolTemplateBundle:Section:properties.html.twig', array(
                    'section' => $section,
                    'config' => $resolver->resolve(),
        ));
    }

    public function allConfigsAction()
    {
        $sections = $this->get('template_section_factory')->getSections();

        $configs = array();

        foreach ($sections as $type => $object) {
            $resolver = new OptionsResolver();
            $object->setDefaultOptions($resolver);
            $configs[$type] = $resolver->resolve();
        }

        return new JsonResponse($configs);
    }

}
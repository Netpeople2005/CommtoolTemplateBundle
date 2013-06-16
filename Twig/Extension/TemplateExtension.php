<?php

namespace Optime\Commtool\TemplateBundle\Twig\Extension;

use Optime\Commtool\TemplateBundle\Section\SectionInterface;

class TemplateExtension extends \Twig_Extension
{

    /**
     *
     * @var \Twig_Environment
     */
    protected $twig;

    public function initRuntime(\Twig_Environment $environment)
    {
        $this->twig = $environment;
    }

    public function getName()
    {
        return 'commtool_template_extension';
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('properties', array($this, 'renderSectionProperties'), array(
                'is_safe' => array('html')
                    ))
        );
    }

    public function renderSectionProperties(SectionInterface $section)
    {
        return $this->getTemplate()->renderBlock($section->getName(), $section->getConfig());
    }
    
    protected function getTemplate(){
        static $template;
        
        if(!$template){
            $template = $this->twig->loadTemplate('CommtoolTemplateBundle::section_layout.html.twig');
        }
        
        return $template;
    }

}

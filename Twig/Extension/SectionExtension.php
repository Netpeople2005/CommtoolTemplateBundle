<?php

namespace Optime\Commtool\TemplateBundle\Twig\Extension;

use \Twig_SimpleFunction as SimpleFunction;

class SectionExtension extends \Twig_Extension
{

    public function getName()
    {
        return 'section';
    }

    public function getFunctions()
    {
        return array(
            new SimpleFunction('section_*', array($this, 'section'), array('is_safe' => array('html'))),
        );
    }

    public function section($type, $id, $bind = false, array $options = array())
    {
        if (!$id) {
            throw new \Exception("El parametro id para la sección section_$type no puede ser vacio");
        }
        $content = " class=\"commtool_section {$type}\" data-id=\"s_$id\" data-type=\"{$type}\" ";
        if ($bind) {
            $content .= $this->getAttrs($type, $id) . ' data-binding ';
        }
        
        return $content;
    }

    public function resolveType($type)
    {
        
    }

    protected function getAttrs($type, $id)
    {
        switch ($type) {
            case 'gallery':
                return "ng-src=\"t_$id\"";
            default:
                return "ng-bind-html-unsafe=\"t_$id\"";
        }
    }

}


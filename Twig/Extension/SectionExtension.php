<?php

namespace Optime\Commtool\TemplateBundle\Twig\Extension;

use \Twig_SimpleFunction as SimpleFunction;
use Optime\Commtool\TemplateBundle\Model\TemplateInterface;

class SectionExtension extends \Twig_Extension
{

    /**
     *
     * @var TemplateInterface
     */
    protected $template;

    public function getTemplate()
    {
        return $this->template;
    }

    public function setTemplate(TemplateInterface $template = null)
    {
        $this->template = $template;
    }

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
        $id = "s_$id";
        if ($this->template) {
            if ($section = $this->template->getSection($id)) {
                $id = $section->getCompleteIdentifier();
            }
        }
        switch ($type) {
            case 'gallery':
                return "ng-src=\"$id\"";
            default:
                return "ng-bind-html-unsafe=\"$id\"";
        }
    }

}


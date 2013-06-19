<?php

namespace Optime\Commtool\TemplateBundle\Twig\Extension;

use \Twig_SimpleFunction as SimpleFunction;
use Optime\Commtool\TemplateBundle\Model\TemplateInterface;
use Optime\Commtool\TemplateBundle\Twig\TokenParser\Singleline;

class SectionExtension extends \Twig_Extension
{

    /**
     *
     * @var TemplateInterface
     */
    protected $template;

    public function getTokenParsers()
    {
        return array(
            new Singleline(),
        );
    }

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
            new SimpleFunction('section_loop', array($this, 'loop'), array('is_safe' => array('html'))),
        );
    }

    public function section($type, $id, $bind = true, array $options = array())
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

    public function loop($id, $bind = true, array $options = array())
    {
        if (!isset($options['type'])) {
            throw new \Exception("Debe especificar un valor para el indice type en las opciones");
        }

        if (!$id) {
            throw new \Exception("El parametro id para la sección section_$type no puede ser vacio");
        }
        $content = " class=\"commtool_section loop_{$options['type']}\" data-id=\"s_$id\" data-type=\"loop\" ";

        if ($bind) {
            $content .= $this->getAttrs('loop', $id) . ' data-binding ';
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
            case 'image':
                return "ng-src=\"{{" . $id . "}}\"";
            default:
                return "ng-bind-html-unsafe=\"$id\"";
        }
    }

}


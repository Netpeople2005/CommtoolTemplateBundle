<?php

namespace Optime\Commtool\TemplateBundle\Twig\Extension;

use \Twig_SimpleFunction as SimpleFunction;
use Optime\Bundle\CommtoolBundle\CommtoolBuilderInterface;
use Optime\Commtool\TemplateBundle\Model\TemplateInterface;

class SectionExtension extends \Twig_Extension
{

    /**
     *
     * @var CommtoolBuilderInterface
     */
    protected $commtool;

    /**
     *
     * @var int
     */
    protected $counter = 0;

    public function getCommtool()
    {
        return $this->commtool;
    }

    public function setCommtool(CommtoolBuilderInterface $commtool = null)
    {
        $this->commtool = $commtool;
        $this->counter = 0;
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

    public function section($type, $name = null, array $options = array())
    {
        if ($name) {
            $class = $name . '_' . $type;
        } else {
            $class = $type;
        }

        $id = $this->counter++;

        $content = " class=\"commtool_section {$class}\" data-id=\"s_$id\" data-type=\"{$type}\" data-name=\"{$class}\" ";

        $content .= $this->getAttrs($type, $id);

        return $content;
    }

    public function loop($name, array $options = array())
    {
        $id = $this->counter++;

        $content = " class=\"commtool_section {$name}_loop\" data-id=\"s_$id\" data-type=\"loop\" data-name=\"{$name}_loop\" ";

        $content .= $this->getAttrs('loop', $id);

        return $content;
    }

    protected function getAttrs($type, $id)
    {
        $id = "s_$id";
        $hasChildren = false;
        $is_html = true;
        if ($this->commtool) {
            if ($control = $this->commtool->getControl($id)) {
                $id = $control->getIndex();
                $hasChildren = count($control->getChildren()) > 0;
                $is_html = $control->getOptions('is_html') ? : false;
            } else {
                return ' ';
            }
        }
        switch ($type) {
            case 'image':
                return "ng-src=\"{{" . $id . ".value}}\" ";
            case 'loop':
                return "ng-repeat=\"$id in " . $id . "\" ";
            default:
                if (!$hasChildren) {
                    if ($is_html) {
                        return "ng-bind-html-unsafe=\"{$id}.value\" ";
                    } else {
                        return "ng-bind=\"{$id}.value\" ";
                    }
                } else {
                    return ' ';
                }
        }
    }

}


<?php

namespace Optime\Commtool\TemplateBundle\Twig\Node;

class Section extends \Twig_Node
{

    protected $content;
    protected $tag;

    function __construct($options, $lineno = null, $tag = null)
    {
        parent::__construct(array(), $options, $lineno, $tag);

        $this->tag = $tag;
    }

    public function compile(\Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this);

        $compiler->write('echo \'<span ')
                ->raw('class=')
                ->string("commtool_section {$this->tag}");
        $this->getAttrs($compiler);
        $compiler->raw('>\';');

        $compiler->subcompile($this->getContent(), false);
        $compiler->write('echo ')->string('</span>')->raw(';');
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    protected function getAttrs(\Twig_Compiler $compiler)
    {
        foreach ($this->attributes as $name => $val) {
            $compiler->raw(" {$name}=")
                    ->subcompile($val);
        }
    }

}

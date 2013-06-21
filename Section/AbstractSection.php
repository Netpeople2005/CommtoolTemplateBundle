<?php

namespace Optime\Commtool\TemplateBundle\Section;

use Optime\Commtool\TemplateBundle\Section\SectionInterface;

abstract class AbstractSection implements SectionInterface
{
    public function getConfig()
    {
        return array(
            'readonly' => false,
            'is_interactive' => true,
            'form_type' => 'text',
        );
    }
    
    public function getName()
    {
        return $this->getType();
    }
}

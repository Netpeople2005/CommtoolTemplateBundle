<?php

namespace Optime\Commtool\TemplateBundle\Section;

use Optime\Commtool\TemplateBundle\Section\SectionInterface;

abstract class AbstractSection implements SectionInterface
{

    public function getConfig()
    {
        return array(
            'read_only' => false,
            'is_interactive' => true,
            'form_type' => 'text',
        );
    }

}

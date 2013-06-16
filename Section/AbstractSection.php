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

    public function elements()
    {
        return array('div', 'td', 'span', 'p', 'strong', 'dl'
            , 'dd', 'li', 'b', ':header', 'em', 'font', 'label', 'a'
            , 'small', 'th');
    }

}

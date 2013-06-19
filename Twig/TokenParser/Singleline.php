<?php

namespace Optime\Commtool\TemplateBundle\Twig\TokenParser;

use Optime\Commtool\TemplateBundle\Twig\TokenParser\AbstractSection;

class Singleline extends AbstractSection
{

    public function getTag()
    {
        return 'singleline';
    }

}

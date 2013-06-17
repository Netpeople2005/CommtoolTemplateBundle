<?php

namespace Optime\Commtool\TemplateBundle\Model;

use Optime\Commtool\TemplateBundle\Section\SectionInterface;

interface SectionConfigInterface extends SectionInterface
{
    public function getIdentifier();
    public function getChildren();
}

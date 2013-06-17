<?php

namespace Optime\Commtool\TemplateBundle\Section;

interface SectionInterface
{

    public function getName();

    public function getConfig();
    
    public function getChildren();
}
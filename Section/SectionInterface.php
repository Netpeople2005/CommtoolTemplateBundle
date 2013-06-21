<?php

namespace Optime\Commtool\TemplateBundle\Section;

interface SectionInterface
{

    public function getName();

    public function getType();

    public function getConfig();
}
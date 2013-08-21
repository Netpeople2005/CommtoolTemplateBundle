<?php

namespace Optime\Commtool\TemplateBundle\Model;

interface SectionConfigInterface
{

    public function getIdentifier();

    public function getCompleteIdentifier();

    public function getChildren();

    public function getParent();

    public function getLabel();

    public function getId();

    public function getName();

    public function getType();

    public function getConfig();
}

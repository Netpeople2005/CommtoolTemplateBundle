<?php

namespace Optime\Commtool\TemplateBundle\Model;

use Optime\Commtool\TemplateBundle\Model\SectionConfigInterface;

interface TemplateInterface
{

    public function getView();

    public function getSections();

    /**
     * 
     * @param string $id
     * @param array $sections
     * @return SectionConfigInterface Description
     */
    public function getSection($id, $sections = null);
}

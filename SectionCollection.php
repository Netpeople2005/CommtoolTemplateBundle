<?php

namespace Optime\Commtool\TemplateBundle;

use Doctrine\Common\Collections\ArrayCollection;

class SectionCollection extends ArrayCollection
{

    public function contains(Entity\TemplateSection $section)
    {
        foreach ($this->getValues() as $current) {
            if ($section->getIdentifier() == $current->getIdentifier()) {
                return true;
            }
        }
        return false;
    }

}

<?php

namespace Optime\Commtool\TemplateBundle\Section;

use Optime\Commtool\TemplateBundle\Section\SectionInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AbstractSection implements SectionInterface
{

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'readonly' => false,
            'is_interactive' => true,
            'form_type' => 'text',
        ));
    }

    public function getName()
    {
        return $this->getType();
    }

}

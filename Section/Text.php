<?php

namespace Optime\Commtool\TemplateBundle\Section;

use Optime\Commtool\TemplateBundle\Section\AbstractSection;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Text extends AbstractSection
{

    public function getType()
    {
        return 'text';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'is_interactive' => false,
        ));
    }

}

<?php

namespace Optime\Commtool\TemplateBundle\Section;

use Optime\Commtool\TemplateBundle\Section\AbstractSection;

class Multiline extends AbstractSection
{

    public function getType()
    {
        return 'multiline';
    }

    public function setDefaultOptions(\Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'is_html' => false,
        ));
    }

}

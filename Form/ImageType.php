<?php

namespace Optime\Commtool\TemplateBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('large')
            ->add('medium')
            ->add('small')
            ->add('status')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Optime\Commtool\TemplateBundle\Entity\Image'
        ));
    }

    public function getName()
    {
        return 'optime_commtool_templatebundle_imagetype';
    }
}

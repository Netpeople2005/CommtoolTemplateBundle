<?php

namespace Optime\Commtool\TemplateBundle\Section;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

interface SectionInterface
{

    /**
     * Devuelve el nombre de la sección, puede variar dependiendo de la config de cada sección
     */
    public function getName();

    /**
     * Devuelve el tipo de sección, para una sección de un tipo definido no cambiará jamas.
     */
    public function getType();

    public function setDefaultOptions(OptionsResolverInterface $resolver);
}
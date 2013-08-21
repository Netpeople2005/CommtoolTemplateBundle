<?php

namespace Optime\Commtool\TemplateBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class SectionPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {

        //añadimos las secciones disponibles al factory
        $definition = $container->getDefinition('template_section_factory');

        $sections = array();

        foreach ($container->findTaggedServiceIds('commtool.section.type') as $serviceId => $tag) {
            if (!isset($tag[0]['alias'])) {
                throw new \Exception("Debe definir un alias para el tag del servicio $serviceId");
            }
            $sections[$tag[0]['alias']] = $serviceId;
        }

        $definition->replaceArgument(1, $sections);

        //ahora añadimos el recurso con los bloques para la config de la sección        
        $resources = $container->getParameter('twig.form.resources');

        $section_resource = 'CommtoolTemplateBundle::section_layout.html.twig';

        if (!in_array($section_resource, $resources)) {
            array_push($resources, $section_resource);
        }

        $container->setParameter('twig.form.resources', $resources);
    }

}

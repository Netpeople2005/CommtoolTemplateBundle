<?php

namespace Optime\Commtool\TemplateBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class SectionPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('template_section_factory');

        $sections = array();

        foreach ($container->findTaggedServiceIds('commtool.section.type') as $serviceId => $tag) {
            if (!isset($tag[0]['alias'])) {
                throw new \Exception("Debe definir un alias para el tag del servicio $serviceId");
            }
            $sections[$tag[0]['alias']] = $serviceId;
        }
        
        $definition->replaceArgument(1, $sections);
    }

}

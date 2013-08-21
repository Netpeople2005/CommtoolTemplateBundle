<?php

namespace Optime\Commtool\TemplateBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Optime\Commtool\TemplateBundle\DependencyInjection\Compiler\SectionPass;
use Optime\Commtool\TemplateBundle\DependencyInjection\Compiler\TwigEnvironmentPass;

class CommtoolTemplateBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new SectionPass());
        $container->addCompilerPass(new TwigEnvironmentPass());
    }

}

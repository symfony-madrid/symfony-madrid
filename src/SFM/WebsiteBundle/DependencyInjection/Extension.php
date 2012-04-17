<?php

namespace SFM\WebsiteBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class TwigExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container)
    {
        $definition = new Definition('SFM\WebsiteBundle\Extension\SFMTwigExtension');
        $definition->addTag('twig.extension');
        $container->setDefinition('sfm_twig_extension', $definition);
    }
}

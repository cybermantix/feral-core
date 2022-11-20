<?php

namespace NoLoCo\Core\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class NolocoCoreExtension extends \Symfony\Component\DependencyInjection\Extension\Extension
{

    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        die('test point 1233');
    }
}
<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\RemoteBundle\DependencyInjection;

use EveryWorkflow\RemoteBundle\Model\RemoteRequestInterface;
use EveryWorkflow\RemoteBundle\Model\RemoteResponseInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class RemoteExtension extends Extension
{
    /**
     * @throws \Exception
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.php');

        $container->registerForAutoconfiguration(RemoteRequestInterface::class)->setShared(false);
        $container->registerForAutoconfiguration(RemoteResponseInterface::class)->setShared(false);
    }
}

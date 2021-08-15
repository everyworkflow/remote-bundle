<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\RemoteBundle;

use EveryWorkflow\RemoteBundle\DependencyInjection\RemoteExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowRemoteBundle extends Bundle
{
    /**
     * @return void
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }

    public function getContainerExtension()
    {
        return new RemoteExtension();
    }
}

<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\RemoteBundle\Factory;

use EveryWorkflow\RemoteBundle\Model\RemoteServiceInterface;

interface RemoteServiceFactoryInterface
{
    public function create(): RemoteServiceInterface;
}

<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\RemoteBundle\Model\Client;

use EveryWorkflow\RemoteBundle\Model\RemoteResponseInterface;

interface RestClientInterface extends RemoteClientInterface
{
    public function setResponseHandler(RemoteResponseInterface $remoteResponse): self;
}

<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\RemoteBundle\Model\Client;

use EveryWorkflow\RemoteBundle\Model\RemoteRequestInterface;
use EveryWorkflow\RemoteBundle\Model\RemoteResponseInterface;

interface RemoteClientInterface
{
    public function setResponseHandler(RemoteResponseInterface $responseHandler): self;

    public function send(RemoteRequestInterface $request): RemoteResponseInterface;
}

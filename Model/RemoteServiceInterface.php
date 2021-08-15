<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\RemoteBundle\Model;

use EveryWorkflow\RemoteBundle\Model\Client\RemoteClientInterface;

interface RemoteServiceInterface
{
    public function setClient(RemoteClientInterface $client): self;

    public function getClient(): RemoteClientInterface;

    public function setRequest(RemoteRequestInterface $request): self;

    public function getRequest(): RemoteRequestInterface;

    public function setResponseHandler(RemoteResponseInterface $responseHandler): self;

    public function getResponseHandler(): RemoteResponseInterface;

    public function send(): RemoteResponseInterface;
}

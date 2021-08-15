<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\RemoteBundle\Model;

use EveryWorkflow\RemoteBundle\Model\Client\RemoteClientInterface;

class RemoteService implements RemoteServiceInterface
{
    protected RemoteClientInterface $client;
    protected RemoteRequestInterface $request;
    protected RemoteResponseInterface $responseHandler;

    public function __construct(
        RemoteClientInterface   $client,
        RemoteRequestInterface  $request,
        RemoteResponseInterface $responseHandler
    ) {
        $this->client = $client;
        $this->request = $request;
        $this->responseHandler = $responseHandler;
    }

    public function setClient(RemoteClientInterface $client): self
    {
        $this->client = $client;
        return $this;
    }

    public function getClient(): RemoteClientInterface
    {
        return $this->client;
    }

    public function setRequest(RemoteRequestInterface $request): self
    {
        $this->request = $request;
        return $this;
    }

    public function getRequest(): RemoteRequestInterface
    {
        return $this->request;
    }

    public function setResponseHandler(RemoteResponseInterface $responseHandler): self
    {
        $this->responseHandler = $responseHandler;
        return $this;
    }

    public function getResponseHandler(): RemoteResponseInterface
    {
        return $this->responseHandler;
    }

    public function send(): RemoteResponseInterface
    {
        return $this->client
            ->setResponseHandler($this->getResponseHandler())
            ->send($this->getRequest());
    }
}

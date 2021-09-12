<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\RemoteBundle\Factory;

use EveryWorkflow\RemoteBundle\Model\Client\RemoteClientInterface;
use EveryWorkflow\RemoteBundle\Model\RemoteRequest;
use EveryWorkflow\RemoteBundle\Model\RemoteResponse;
use EveryWorkflow\RemoteBundle\Model\RemoteService;
use EveryWorkflow\RemoteBundle\Model\RemoteServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RemoteServiceFactory implements RemoteServiceFactoryInterface
{
    protected string $requestClassName;
    protected string $responseHandlerClassName;

    protected ContainerInterface $container;
    protected RemoteClientInterface $client;

    public function __construct(
        ContainerInterface $container,
        RemoteClientInterface $client,
        string $requestClassName = RemoteRequest::class,
        string $responseHandlerClassName = RemoteResponse::class
    ) {
        $this->container = $container;
        $this->client = $client;
        $this->requestClassName = $requestClassName;
        $this->responseHandlerClassName = $responseHandlerClassName;
    }

    public function create(): RemoteServiceInterface
    {
        return new RemoteService(
            $this->client,
            $this->container->get($this->requestClassName),
            $this->container->get($this->responseHandlerClassName)
        );
    }
}

<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EveryWorkflow\RemoteBundle\Model\Client\RemoteClient;
use EveryWorkflow\RemoteBundle\Model\Client\RemoteClientInterface;
use EveryWorkflow\RemoteBundle\Model\Client\RestClient;
use EveryWorkflow\RemoteBundle\Model\Formatter\ArrayFormatter;
use EveryWorkflow\RemoteBundle\Model\Formatter\ArrayFormatterInterface;
use EveryWorkflow\RemoteBundle\Model\Formatter\JsonFormatter;
use EveryWorkflow\RemoteBundle\Model\Formatter\JsonFormatterInterface;
use EveryWorkflow\RemoteBundle\Model\RemoteService;

return function (ContainerConfigurator $configurator) {
    /** @var DefaultsConfigurator $services */
    $services = $configurator
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $services
        ->load('EveryWorkflow\\RemoteBundle\\', '../../*')
        ->exclude('../../{DependencyInjection,Resources,Support,Tests}');

    $services->set(RemoteClientInterface::class, RemoteClient::class);

    $services->set(ArrayFormatterInterface::class, ArrayFormatter::class);
    $services->set(JsonFormatterInterface::class, JsonFormatter::class);

    $services->set(RestClient::class)
        ->arg('$formatter', service(JsonFormatter::class))
        ->arg('$config', ['connect_timeout' => 120.0]);

    $services->set(RemoteClient::class)
        ->arg('$ewRemoteLogger', service('monolog.logger.ew_remote'))
        ->tag('monolog.logger', ['channel' => 'ew_remote']);

    $services->set(RemoteService::class)
        ->arg('$client', service(RestClient::class));
};

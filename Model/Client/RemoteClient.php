<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\RemoteBundle\Model\Client;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use EveryWorkflow\RemoteBundle\Model\Formatter\ArrayFormatterInterface;
use EveryWorkflow\RemoteBundle\Model\RemoteRequestInterface;
use EveryWorkflow\RemoteBundle\Model\RemoteResponseInterface;
use Psr\Log\LoggerInterface;

class RemoteClient implements RemoteClientInterface
{
    protected ArrayFormatterInterface $formatter;
    protected LoggerInterface $logger;

    public function __construct(
        ArrayFormatterInterface $formatter,
        LoggerInterface $ewRemoteLogger
    ) {
        $this->formatter = $formatter;
        $this->logger = $ewRemoteLogger;
    }

    public function send(RemoteRequestInterface $request): RemoteResponseInterface
    {
        $this->logRequest($request);
        
        $response = $this->formatter->handle($request->toArray());

        $this->logResponse($request, $response);

        return $response;
    }

    protected function logRequest(RemoteRequestInterface $request): void
    {
        $this->logger->info(
            'Request: ' .
                $request->getRequestKey() .
                ' || ' .
                strtoupper($request->getMethod()) .
                ': ' .
                $request->getUri() .
                ' || ' .
                json_encode($request->toArray(), 1)
        );
    }

    protected function logResponse(RemoteRequestInterface $request, DataObjectInterface $response): void
    {
        $this->logger->info(
            'Response: ' .
                $request->getRequestKey() .
                ' || ' .
                strtoupper($request->getMethod()) .
                ': ' .
                $request->getUri() .
                ' || ' .
                json_encode($response->toArray(), 1)
        );
    }
}

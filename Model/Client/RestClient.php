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
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Exception\RequestException;

class RestClient extends RemoteClient implements RestClientInterface
{
    protected Client $client;

    public function __construct(
        RemoteResponseInterface $responseHandler,
        LoggerInterface         $ewRemoteLogger,
        ArrayFormatterInterface $formatter,
        array                   $config = []
    ) {
        parent::__construct($responseHandler, $ewRemoteLogger, $formatter);
        $this->client = new Client($config);
    }

    protected function getUrlFromUri(RemoteRequestInterface $request): string
    {
        $uri = $request->getUri();
        if (false !== strpos($uri, 'http://') || false !== strpos($uri, 'https://')) {
            return $uri;
        }

        return $uri;
    }

    protected function getOptions(RemoteRequestInterface $request): array
    {
        return [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ];
    }

    public function send(RemoteRequestInterface $request): RemoteResponseInterface
    {
        $this->logRequest($request);

        if (!$this->responseHandler) {
            throw new \Exception('Response handler not found.');
        }

        try {
            $rawResponse = $this->client->request(
                $request->getMethod(),
                $this->getUrlFromUri($request),
                $this->getOptions($request)
            );
        } catch (RequestException $e) {
            $rawResponse = $e->getResponse();
            if (!$rawResponse) {
                throw new \Exception('Response Error: ' . $e->getMessage());
            }
            $this->logRowResponse($request, $rawResponse);
        }

        $arrayResponse = $this->formatter->handle($rawResponse);
        $response = $this->responseHandler
            ->setStatusCode($rawResponse->getStatusCode())
            ->setRequest($request)
            ->handle($arrayResponse);

        $this->logResponse($request, $response);

        return $this->responseHandler;
    }

    protected function logRequest(RemoteRequestInterface $request): void
    {
        $options = $this->getOptions($request);
        if (isset($options['headers'])) {
            unset($options['headers']);
        }

        $this->logger->info(
            'Request: ' .
            $request->getRequestKey() .
            ' || ' .
            strtoupper($request->getMethod()) .
            ': ' .
            $this->getUrlFromUri($request) .
            ' || Options: ' .
            json_encode($options, 1)
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
            $this->getUrlFromUri($request) .
            ' || Content: ' .
            json_encode($response->toArray(), 1)
        );
    }

    protected function logRowResponse(RemoteRequestInterface $request, ResponseInterface $response): void
    {
        $this->logger->info(
            'Response Error: ' .
            $request->getRequestKey() .
            ' || ' .
            strtoupper($request->getMethod()) .
            ': ' .
            $this->getUrlFromUri($request) .
            ' || StatusCode: ' .
            $rawResponse->getStatusCode()
        );
    }
}

<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\RemoteBundle\Model\Client;

use EveryWorkflow\RemoteBundle\Model\Formatter\ArrayFormatterInterface;
use EveryWorkflow\RemoteBundle\Model\RemoteRequestInterface;
use EveryWorkflow\RemoteBundle\Model\RemoteResponseInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class OfflineClient extends RemoteClient implements OfflineClientInterface
{
    protected Filesystem $filesystem;
    protected KernelInterface $kernel;

    public function __construct(
        RemoteResponseInterface $responseHandler,
        LoggerInterface $ewRemoteLogger,
        ArrayFormatterInterface $formatter,
        Filesystem $filesystem,
        KernelInterface $kernel
    ) {
        parent::__construct($responseHandler, $ewRemoteLogger, $formatter);
        $this->filesystem = $filesystem;
        $this->kernel = $kernel;
    }

    public function send(RemoteRequestInterface $request): RemoteResponseInterface
    {
        /* Dump request to request_id for future processing */
        $exportFileName = $this->getExportFileName($request);
        $content = 'Request: ' . $request->getRequestKey() . PHP_EOL;
        $content .= strtoupper($request->getMethod()) . ': ' . $request->getUri() . PHP_EOL;
        $content .= json_encode($request->toArray(), 1) . PHP_EOL;
        $this->filesystem->dumpFile($exportFileName, $content);

        return parent::send($request)->setStatusCode(200);
    }

    protected function getExportFileName(RemoteRequestInterface $request): string
    {
        return $this->kernel->getLogDir() . '/ew_remote/' . $request->getRequestKey() . '.txt';
    }
}

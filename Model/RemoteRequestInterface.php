<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\RemoteBundle\Model;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;

interface RemoteRequestInterface extends DataObjectInterface
{
    public const METHOD_GET = 'get';
    public const METHOD_POST = 'post';

    public const KEY_URI = 'uri';
    public const KEY_METHOD = 'method';
    public const KEY_REQUEST_KEY = 'request_key';

    public function setMethod(string $method): self;

    public function getMethod(): string;

    public function getRequestKey(): string;

    public function setRequestKey(string $requestKey): self;

    public function setUri(string $uri): self;

    public function getUri(): string;
}

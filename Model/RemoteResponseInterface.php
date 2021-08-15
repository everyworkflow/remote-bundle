<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\RemoteBundle\Model;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;

interface RemoteResponseInterface extends DataObjectInterface
{
    public const KEY_STATUS_CODE = 'status_code';

    public function getStatusCode(): int;
    public function setStatusCode(int $statusCode): self;

    public function getRequest(): ?RemoteRequestInterface;
    public function setRequest(RemoteRequestInterface $request): self;

    public function handle(array $responseData): self;
}

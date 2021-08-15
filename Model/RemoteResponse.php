<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\RemoteBundle\Model;

use EveryWorkflow\CoreBundle\Model\DataObject;

class RemoteResponse extends DataObject implements RemoteResponseInterface
{
    protected int $statusCode = 0;

    protected ?RemoteRequestInterface $request = null;

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getRequest(): ?RemoteRequestInterface
    {
        return $this->request;
    }

    public function setRequest(RemoteRequestInterface $request): self
    {
        $this->request = $request;
        return $this;
    }

    public function handle(array $responseData): self
    {
        $this->data = array_merge($this->data, $responseData);
        return $this;
    }
}

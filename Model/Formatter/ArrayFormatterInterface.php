<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\RemoteBundle\Model\Formatter;

interface ArrayFormatterInterface
{
    public function handle(mixed $rawResponse): mixed;
}

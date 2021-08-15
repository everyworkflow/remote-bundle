<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\RemoteBundle\Model\Formatter;

class ArrayFormatter implements ArrayFormatterInterface
{
    public function handle(mixed $rawResponse): mixed
    {
        if (is_array($rawResponse)) {
            return $rawResponse;
        }

        return [];
    }
}

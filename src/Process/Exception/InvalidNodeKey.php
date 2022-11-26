<?php

namespace NoLoCo\Core\Process\Exception;

use Exception;

/**
 * Invalid node key
 */
class InvalidNodeKey extends Exception
{
    public function __construct(
        private string $key,
        string $message = "",
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }
}

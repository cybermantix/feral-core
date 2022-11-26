<?php

namespace NoLoCo\Core\Process\Exception;

use Exception;

/**
 * The key for a node code is invalid.
 */
class InvalidNodeCodeKey extends Exception
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

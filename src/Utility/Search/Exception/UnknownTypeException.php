<?php


namespace Feral\Core\Utility\Search\Exception;

use Exception;
use Throwable;

/**
 * The type of data is not supported.
 * Class UnknownTypeException
 *
 * @package Nodez\Utility\Search\Exception
 */
class UnknownTypeException extends Exception
{
    protected string $data;

    public function __construct($data, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->data = $data;
        parent::__construct($message, $code, $previous);
    }
}

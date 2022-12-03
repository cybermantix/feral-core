<?php


namespace Nodez\Core\Utility\Search\Exception;

use Exception;
use Throwable;

/**
 * The class of the data didn't match the expected class.
 * Class UnknownTypeException
 *
 * @package Nodez\Utility\Search\Exception
 */
class WrongTypeException extends Exception
{
    protected string $data;

    public function __construct($data, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->data = $data;
        parent::__construct($message, $code, $previous);
    }
}

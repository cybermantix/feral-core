<?php

namespace Feral\Core\Utility\Search;

use stdClass;
use Feral\Core\Utility\Search\Exception\UnknownTypeException;

/**
 * This general utility will allow data be modified in an object or
 * array.
 *
 * @package Nodez\Utility\Search
 */
interface DataPathWriterInterface
{
    /**
     * Set a value into an array or object
     *
     * @param  stdClass|array $data  The data to set the value into
     * @param  string         $path  The path in the data to set the key
     * @param  mixed          $value The value to set in the data
     * @return mixed return the modified data object.
     * @throws UnknownTypeException
     */
    public function set(mixed $data, mixed $value, string $path): mixed;
}

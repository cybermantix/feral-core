<?php

namespace Feral\Core\Utility\Search;

use Feral\Core\Utility\Search\Exception\WrongTypeException;
use stdClass;
use Feral\Core\Utility\Search\Exception\UnknownTypeException;

/**
 * This general utility will allow data to be found and typed within a set of data.
 * Interface DataPathReaderInterface
 *
 */
interface DataPathReaderInterface
{
    const DEFAULT_DELIMITER = '|';

    /**
     * Get a value or array of values from data
     *
     * @param  $data
     * @param  string $path
     * @return mixed
     * @throws UnknownTypeException
     */
    public function get($data, string $path);

    /**
     * Get an int value from the data
     *
     * @param  $data
     * @param  string   $path
     * @param  int|null $default
     * @return mixed
     */
    public function getInt($data, string $path, int $default = null): ?int;

    /**
     * Get a float value from the data. If the value is null an optional default will be returned.
     *
     * @param  $data
     * @param  string     $path
     * @param  float|null $default
     * @return float|null
     */
    public function getFloat($data, string $path, float $default = null): ?float;

    /**
     * Get a string value from the data. If the value is null an optional default will be returned.
     *
     * @param  $data
     * @param  string      $path
     * @param  string|null $default
     * @return string|null
     */
    public function getString($data, string $path, string $default = null): ?string;

    /**
     * Get an array value from the data. If the value is null an optional default will be returned.
     *
     * @param  $data
     * @param  string     $path
     * @param  array|null $default
     * @return array|null
     */
    public function getArray($data, string $path, array $default = null): ?array;

    /**
     * Get an object value from the data. If the value is null an optional default will be returned.
     *
     * @param  $data
     * @param  string        $path
     * @param  string|null   $fqcn
     * @param  stdClass|null $default
     * @return stdClass|null
     * @throws WrongTypeException
     */
    public function getObject($data, string $path, string $fqcn = null, stdClass $default = null): ?stdClass;
}

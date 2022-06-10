<?php


namespace NoLoCo\Core\Utility\Search;

use NoLoCo\Core\Utility\Search\Exception\WrongTypeException;
use stdClass;
use NoLoCo\Core\Utility\Search\Exception\UnknownTypeException;

/**
 * The datapath reader will walk an array or object and find
 * the value based on the string path passed into the get. Use the
 * delimiter to separate the path parts.
 *
 * EX: one|two|three will walk the data and look for an array index
 * of 'one', when found, it will walk the data for that key and walk
 * the current object for the path 'two' and so on.
 */
class DataPathReader implements DataPathReaderInterface
{
    const DEFAULT_ACCESSOR_VERBS = ['get', 'is'];

    /**
     * The path delimiter which to explode a string into an array
     * @var string
     */
    protected string $delimiter = DataPathReaderInterface::DEFAULT_DELIMITER;
    
    protected array $objectAccessorVerbs = self::DEFAULT_ACCESSOR_VERBS;

    /**
     * @inheritDoc
     * @throws UnknownTypeException
     */
    public function get($data, string $path)
    {
        $keys = explode($this->delimiter, $path);
        return $this->doGet($data, $keys);
    }

    /**
     * @inheritDoc
     */
    public function getInt($data, string $path, int $default = null): ?int
    {
        $datum = $this->get($data, $path);
        if(!is_null($datum)) {
            return $datum;
        } else {
            return $default;
        }
    }

    /**
     * @inheritDoc
     */
    public function getFloat($data, string $path, float $default = null): ?float
    {
        $datum = $this->get($data, $path);
        if(!is_null($datum)) {
            return $datum;
        } else {
            return $default;
        }
    }

    /**
     * @inheritDoc
     */
    public function getString($data, string $path, string $default = null): ?string
    {
        $datum = $this->get($data, $path);
        if(!is_null($datum)) {
            return $datum;
        } else {
            return $default;
        }
    }

    /**
     * @inheritDoc
     */
    public function getArray($data, string $path, array $default = null): ?array
    {
        $datum = $this->get($data, $path);
        if(!is_null($datum)) {
            return $datum;
        } else {
            return $default;
        }
    }

    /**
     * @inheritDoc
     */
    public function getObject($data, string $path, string $fqcn = null, stdClass $default = null): ?stdClass
    {
        $datum = $this->get($data, $path);
        if(!is_null($datum)) {
            if ($fqcn && !is_a($datum, $fqcn)) {
                throw new WrongTypeException($datum, sprintf('Was expecting "%s"', $fqcn));
            }
            return $datum;
        } else {
            return $default;
        }
    }

    /**
     * @param $data
     * @param array $path
     * @return mixed
     * @throws UnknownTypeException
     */
    protected function doGet($data, array $path): mixed
    {
        $key = array_shift($path);
        $value = null;
        if (is_scalar($data)) {
            $value = $this->getFromScalar($data, $key);
        } elseif (is_array($data)) {
            $value = $this->getFromArray($data, $key, $path);
        } elseif (is_object($data)) {
            $value = $this->getFromObject($data, $key);
        } else {
            throw new UnknownTypeException($data, 'The data must be a scalar, array, or object');
        }
        if (empty($path)) {
            return $value;
        } else {
            return $this->doGet($value, $path);
        }
    }

    /**
     * Get mixed data from a scalar
     * @param $data
     * @param string $key
     * @return mixed
     */
    protected function getFromScalar($data, string $key): mixed
    {
        return $data;
    }

    /**
     * Get a mixed value from an array
     * @param array $data
     * @param string $key
     * @param array $path
     * @return array|mixed
     * @throws UnknownTypeException
     */
    protected function getFromArray(array $data, string $key, array $path): mixed
    {
        if (isset($data[$key])) {
            return $data[$key];
        } elseif (empty($path)) {
            return null;
        } else {
            $values = [];
            foreach ($data as $datum){
                $results = $this->doGet($datum, $path);
                if($results){
                    $values[] = $results;
                }
            }
            return $values;
        }
    }

    /**
     * Get a mixed variable from an object
     *   1. CHECK IF THE ACCESSOR METHOD EXISTS
     *   2. CHECK IF A GENERAL GET FUNCTION EXISTS
     *   3. CHECK IF THE PROPERTY IS EXPOSED
     * @param $data
     * @param string $key
     * @return mixed|null
     */
    protected function getFromObject($data, string $key): mixed
    {


        foreach ($this->objectAccessorVerbs as $accessorVerb) {
            $property = str_replace(' ', '', ucwords(str_replace(['_', '-'], ' ', $key)));
            $testMethod = $accessorVerb . $property;
            if (method_exists($data, $testMethod)) {
                return $data->$testMethod();
            }
        }

        if (method_exists($data, 'get')) {
            return $data->get($key);
        }

        $property = lcfirst(str_replace(' ', '', ucwords(str_replace(['_', '-'], ' ', $key))));
        if (property_exists($data, $property)) {
            return $data->$property;
        }
        return null;
    }
}

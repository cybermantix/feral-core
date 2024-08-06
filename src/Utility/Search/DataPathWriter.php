<?php


namespace Feral\Core\Utility\Search;

use Feral\Core\Utility\Search\Exception\WrongTypeException;
use stdClass;
use Feral\Core\Utility\Search\Exception\UnknownTypeException;

/**
 * The datapath writer will write a value into the data at
 * a certain key in the data. When returning an array value,
 * the getter must return a reference.
 *
 * E.G. public function &get(string $key): mixed
 */
class DataPathWriter implements DataPathWriterInterface
{
    const DEFAULT_MUTATION_VERBS = ['add', 'set'];

    const DEFAULT_ACCESSOR_VERBS = ['get', 'is'];

    /**
     * The path delimiter which to explode a string into an array
     *
     * @var string
     */
    protected string $delimiter = DataPathReaderInterface::DEFAULT_DELIMITER;

    /**
     * The verbs to check if the data object is a class.
     *
     * @var string[]
     */
    protected array $objectMutatorVerbs = self::DEFAULT_MUTATION_VERBS;

    protected array $objectAccessorVerbs = self::DEFAULT_ACCESSOR_VERBS;

    /**
     * @inheritDoc
     * @throws     UnknownTypeException
     * @throws     \Exception
     */
    public function set(mixed $data, mixed $value, string $path): mixed
    {
        $keys = explode($this->delimiter, $path);
        if (is_array($data)) {
            $parent = &$data;
        } else {
            $parent = $data;
        }

        while (0 < count($keys)) {
            $key = array_shift($keys);
            // SET THE VALUE
            if (0 == count($keys)) {
                // SET THE VALUE IN THE PARENT
                if (is_array($parent)) {
                    $parent[$key] = $value;
                } else if (is_object($parent)) {
                    $foundSetter = false;
                    foreach ($this->objectMutatorVerbs as $verb) {
                        $property = str_replace(' ', '', ucwords(str_replace(['_', '-'], ' ', $key)));
                        $testMethod = $verb . $property;
                        if (method_exists($parent, $testMethod)) {
                            $parent->$testMethod($value);
                            $foundSetter = true;
                            break;
                        }
                    }

                    if (!$foundSetter && method_exists($data, 'set')) {
                        $parent->set($key, $value);
                        $foundSetter = true;
                    }

                    // TRY TO WRITE TO THE PROPERTY
                    if (!$foundSetter) {
                        $property = lcfirst(str_replace(' ', '', ucwords(str_replace(['_', '-'], ' ', $key))));
                        if (property_exists($data, $property)) {
                            $parent->$property = $value;
                            $foundSetter = true;
                        }
                    }
                    if (!$foundSetter) {
                        throw new \Exception('Path not found');
                    }
                }
                break;
            }

            // CONTINUE DOWN PATH
            if (is_array($parent)) {
                $parent =& $parent[$key];
            } elseif (is_object($parent)) {
                $foundGetter = false;
                foreach ($this->objectAccessorVerbs as $accessorVerb) {
                    $property = str_replace(' ', '', ucwords(str_replace(['_', '-'], ' ', $key)));
                    $testMethod = $accessorVerb . $property;
                    if (method_exists($parent, $testMethod)) {
                        // THE GET MUST RETURN A REFERENCE. See note in the prolog
                        $parent =& $parent->$testMethod();
                        $foundGetter = true;
                        break;
                    }
                }

                if (!$foundGetter && method_exists($parent, 'get')) {
                    // THE GET MUST RETURN A REFERENCE. See note in the prolog
                    $parent =& $parent->get($key);
                    $foundGetter = true;
                }

                if (!$foundGetter) {
                    $property = lcfirst(str_replace(' ', '', ucwords(str_replace(['_', '-'], ' ', $key))));
                    if (property_exists($parent, $property)) {
                        $parent = &$parent->$property;
                        $foundGetter = true;
                    }
                }
                if (!$foundGetter) {
                    throw new \Exception('Path not found');
                }
            }
        }
        return $data;
    }
}

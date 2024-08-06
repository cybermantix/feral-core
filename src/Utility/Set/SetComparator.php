<?php


namespace Feral\Core\Utility\Set;


use Feral\Core\Utility\Search\DataPathReader;
use Feral\Core\Utility\Search\Exception\UnknownTypeException;
use Feral\Core\Utility\Set\Exception\InvalidSetException;

/**
 * Class SetComparison
 * Compare two sets to identify if each set has a value held
 * at a particular key path.
 *
 * Example:
 *    $comparator = new SetComparator();
 *    $comparator
 *       ->setLeft($someArray)
 *       ->setRight($anotherCollection)
 *       ->process('suid');
 *    $matchingItems = $comparator->getMatching();
 *    $leftOnlyItems = $comparator->getLeftOnly();
 *    $rightOnlyItems = $comparator->getRightOnly();
 *
 */
class SetComparator
{
    protected DataPathReader $dataPathReader;

    /**
     * @var mixed
     */
    protected $left;

    /**
     * @var mixed
     */
    protected $right;

    /**
     * Keys only found in the left set
     *
     * @var array
     */
    protected array $leftOnlyKeys = [];

    /**
     * @var array
     */
    protected array $rightOnlyKeys = [];

    /**
     * @var array
     */
    protected array $matchingKeys = [];

    /**
     * SetComparison constructor.
     *
     * @param DataPathReader|null $dataPathReader
     */
    public function __construct(DataPathReader $dataPathReader = null)
    {
        if (!$dataPathReader) {
            $this->dataPathReader = new DataPathReader();
        } else {
            $this->dataPathReader = $dataPathReader;
        }
    }

    /**
     * @param  mixed $left
     * @return SetComparator
     */
    public function setLeft($left): self
    {
        $this->left = $left;
        return $this;
    }

    /**
     * @param  mixed $right
     * @return SetComparator
     */
    public function setRight($right): self
    {
        $this->right = $right;
        return $this;
    }

    /**
     * @param  string      $keyPath
     * @param  string|null $rightKeyPath Optional right key path if different than the left.
     * @return SetComparator
     * @throws InvalidSetException
     * @throws UnknownTypeException
     */
    public function process(string $keyPath, string $rightKeyPath = null): self
    {
        if (!isset($this->left) || !isset($this->right)) {
            throw new InvalidSetException('Both left and right sets are required.');
        }
        if (!$rightKeyPath) {
            $rightKeyPath = $keyPath;
        }

        $leftKeys = [];
        $rightKeys = [];
        // CHECK LEFT AND MATCHING
        foreach ($this->left as $key => $leftItem) {
            $leftKeys[$key] = $this->dataPathReader->get($leftItem, $keyPath);
        }
        foreach ($this->right as $key => $rightItem) {
            $rightKeys[] = $this->dataPathReader->get($rightItem, $rightKeyPath);
        }

        $this->leftOnlyKeys = array_keys(array_diff($leftKeys, $rightKeys));
        $this->rightOnlyKeys = array_keys(array_diff($rightKeys, $leftKeys));
        $this->matchingKeys = array_keys(array_intersect($leftKeys, $rightKeys));
        return $this;
    }

    /**
     * Get an array of items found in both.
     * NOTE: Returns the value stored in the left set.
     *
     * @return array
     */
    public function getMatchingOnly(): array
    {
        $results = [];
        foreach ($this->matchingKeys as $key) {
            $results[] = $this->left[$key];
        }
        return $results;
    }

    /**
     * Get an array of the values only found in the left set.
     *
     * @return array
     */
    public function getLeftOnly(): array
    {
        $results = [];
        foreach ($this->leftOnlyKeys as $key) {
            $results[] = $this->left[$key];
        }
        return $results;
    }

    /**
     * Get an array of the values only found in the left set.
     *
     * @return array
     */
    public function getRightOnly(): array
    {
        $results = [];
        foreach ($this->rightOnlyKeys as $key) {
            $results[] = $this->right[$key];
        }
        return $results;
    }
}

<?php

namespace NoLoCo\Core\Process\NodeCode\Traits;

use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Utility\Search\DataPathReader;
use NoLoCo\Core\Utility\Search\Exception\UnknownTypeException;

/**
 * Add the functions to get values from the context.
 */
trait ContextValueTrait
{
    protected DataPathReader $dataPathReader;

    /**
     * @param DataPathReader $dataPathReader
     */
    public function setDataPathReader(DataPathReader $dataPathReader): static
    {
        $this->dataPathReader = $dataPathReader;
        return $this;
    }
    
    /**
     * A helper function to get a value from the context.
     * @param string $key
     * @param ContextInterface $context
     * @return mixed
     * @throws UnknownTypeException
     */
    protected function getValueFromContext(string $key, ContextInterface $context): mixed
    {
        return $this->dataPathReader->get($context, $key);
    }

    /**
     * Get an int value from the context
     * @param string $key
     * @param ContextInterface $context
     * @return int
     */
    protected function getRequiredIntValueFromContext(string $key, ContextInterface $context): int
    {
        return $this->getIntValueFromContext($key, $context);
    }

    /**
     * @param string $key
     * @param ContextInterface $context
     * @return string
     */
    protected function getStringValueFromContext(string $key, ContextInterface $context): string
    {
        return $this->getRequiredIntValueFromContext($key, $context);
    }
}
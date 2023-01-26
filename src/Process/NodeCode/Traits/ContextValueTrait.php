<?php

namespace Feral\Core\Process\NodeCode\Traits;

use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Utility\Search\DataPathReader;
use Feral\Core\Utility\Search\Exception\UnknownTypeException;

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
     *
     * @param  string           $key
     * @param  ContextInterface $context
     * @return mixed
     * @throws UnknownTypeException
     */
    protected function getValueFromContext(string $key, ContextInterface $context): mixed
    {
        return $this->dataPathReader->get($context, $key);
    }

    /**
     * Get an int value from the context
     *
     * @param string $key
     * @param ContextInterface $context
     * @return int
     * @throws \Exception
     */
    protected function getRequiredValueFromContext(string $key, ContextInterface $context): mixed
    {
        $data = $this->getValueFromContext($key, $context);
        if ($data) {
            return $data;
        } else {
            throw new \Exception(sprintf('Value not found for key "%s"', $key));
        }
    }

    /**
     * Get an int value from the context
     *
     * @param  string           $key
     * @param  ContextInterface $context
     * @return int
     */
    protected function getRequiredIntValueFromContext(string $key, ContextInterface $context): int
    {
        return (int)$this->getRequiredValueFromContext($key, $context);
    }

    /**
     * @param  string           $key
     * @param  ContextInterface $context
     * @return string
     */
    protected function getStringValueFromContext(string $key, ContextInterface $context): string
    {
        return (string)$this->getRequiredValueFromContext($key, $context);
    }
}

<?php

namespace NoLoCo\Core\Process\NodeCode\Traits;

use Exception;
use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Utility\Search\DataPathReader;
use NoLoCo\Core\Utility\Search\DataPathReaderInterface;
use NoLoCo\Core\Utility\Search\DataPathWriter;
use NoLoCo\Core\Utility\Search\Exception\UnknownTypeException;

/**
 * Mutate the context by adding or removing values.
 */
trait ContextMutationTrait
{
    protected DataPathWriter $dataPathWriter;

    /**
     * @param DataPathWriter $dataPathWriter
     * @return ContextMutationTrait
     */
    public function setDataPathWriter(DataPathWriter $dataPathWriter): static
    {
        $this->dataPathWriter = $dataPathWriter;
        return $this;
    }

    /**
     * A helper function to set a value in the context.
     * @param string $path
     * @param mixed $value
     * @param ContextInterface $context
     * @return mixed
     * @throws UnknownTypeException
     * @throws Exception
     */
    protected function setValueInContext(string $path, mixed $value, ContextInterface $context): static
    {
        if (str_starts_with($path, '_')) {
            throw new Exception('Path may not start with underscores.');
        }
        $this->dataPathWriter->set($context, $value, $path);
        return $this;
    }
}
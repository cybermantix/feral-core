<?php

namespace Nodez\Core\Process\NodeCode\Traits;

use Exception;
use Nodez\Core\Process\Context\ContextInterface;
use Nodez\Core\Utility\Search\DataPathWriter;
use Nodez\Core\Utility\Search\Exception\UnknownTypeException;

/**
 * Mutate the context by adding or removing values.
 */
trait ContextMutationTrait
{
    protected DataPathWriter $dataPathWriter;

    /**
     * @param  DataPathWriter $dataPathWriter
     * @return ContextMutationTrait
     */
    public function setDataPathWriter(DataPathWriter $dataPathWriter): static
    {
        $this->dataPathWriter = $dataPathWriter;
        return $this;
    }

    /**
     * A helper function to set a value in the context.
     *
     * @param  string           $path
     * @param  mixed            $value
     * @param  ContextInterface $context
     * @return mixed
     * @throws UnknownTypeException
     * @throws Exception
     */
    protected function setValueInContext(string $path, mixed $value, ContextInterface $context): static
    {
        if (str_starts_with($path, '.')) {
            throw new Exception('Path may not start with period.');
        }
        $this->dataPathWriter->set($context, $value, $path);
        return $this;
    }
}

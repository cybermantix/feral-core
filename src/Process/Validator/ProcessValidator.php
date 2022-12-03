<?php

namespace NoLoCo\Core\Process\Validator;

use NoLoCo\Core\Process\ProcessInterface;

/**
 * Validate the nodes, edges, and start key against all of the available
 * validators.
 */
class ProcessValidator implements ProcessValidatorInterface
{
    public function __construct(private iterable $validators = [])
    {
    }

    /**
     * @inheritDoc
     */
    public function validate(ProcessInterface $process, string $startKey = 'start'): array
    {
        $nodes = $process->getNodes();
        $edges = $process->getEdges();
        $errors = [];
        /**
 * @var ValidatorInterface $validator
*/
        foreach ($this->validators as $validator) {
            $error = $validator->getValidationError($startKey, $nodes, $edges);
            if ($error) {
                $errors[] = $error;
            }
        }
        return $errors;
    }
}

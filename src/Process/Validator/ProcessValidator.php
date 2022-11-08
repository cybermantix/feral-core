<?php

namespace NoLoCo\Core\Process\Validator;

use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

/**
 * Validate the nodes, edges, and start key against all of the available
 * validators.
 */
class ProcessValidator implements ProcessValidatorInterface
{
    private iterable $validators;

    public function __construct(
        #[TaggedIterator('noloco.process_validator')] iterable $validators
    ) {
        $this->validators = $validators;
    }

    /**
     * @inheritDoc
     */
    public function validate(string $startKey, array $nodes, array $edges): array
    {
        $errors = [];
        /** @var ValidatorInterface $validator */
        foreach ($this->validators as $validator) {
            $error = $validator->getValidationError($startKey, $nodes, $edges);
            if ($error) {
                $errors[] = $error;
            }
        }
        return $errors;
    }
}
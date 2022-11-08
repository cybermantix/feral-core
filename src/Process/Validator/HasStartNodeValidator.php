<?php

namespace NoLoCo\Core\Process\Validator;

/**
 * Check if the set of nodes contains the start node.
 */
class HasStartNodeValidator implements ValidatorInterface
{

    /**
     * @inheritDoc
     */
    public function getValidationError(string $startKey, array $nodes, array $edges): ?string
    {
        $hasNode = false;
        foreach ($nodes as $node) {
            if ($node->getKey() == $startKey) {
                $hasNode = true;
                break;
            }
        }

        if ($hasNode) {
            return null;
        } else {
            return sprintf('The process nodes do not contain the key "%s".', $startKey);
        }
    }
}
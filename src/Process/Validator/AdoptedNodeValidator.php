<?php

namespace NoLoCo\Core\Process\Validator;

/**
 * Make sure all the nodes have edges pointing to them.
 */
class AdoptedNodeValidator implements ValidatorInterface
{
    /**
     * @inheritDoc
     */
    public function getValidationError(string $startKey, array $nodes, array $edges): ?string
    {
        $edgeKeys = [$startKey];
        foreach ($edges as $edge) {
            $edgeKeys[] = $edge->getToKey();
        }
        $edgeKeys = array_unique($edgeKeys);

        $nodeKeys = [];
        foreach ($nodes as $node) {
            $nodeKeys[] = $node->getKey();
        }

        $missingKeys = array_diff($nodeKeys, $edgeKeys);

        if (empty($missingKeys)) {
            return null;
        } else {
            return sprintf('The nodes are orphaned "%s".', implode(', ', $missingKeys));
        }
    }
}

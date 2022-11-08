<?php

namespace NoLoCo\Core\Process\Validator;

/**
 * Check if the set of nodes contains the start node.
 */
class EdgesExistValidator implements ValidatorInterface
{

    /**
     * @inheritDoc
     */
    public function getValidationError(string $startKey, array $nodes, array $edges): ?string
    {
        $edgeKeys = [];
        foreach ($edges as $edge) {
            $edgeKeys[] = $edge->getToKey();
            $edgeKeys[] = $edge->getFromKey();
        }
        $edgeKeys = array_unique($edgeKeys);

        $foundKeys = [];
        foreach ($edgeKeys as $key) {
            foreach ($nodes as $node) {
                if ($node->getKey() == $key) {
                    $foundKeys[] = $key;
                }
            }
        }

        $missingKeys = array_diff($edgeKeys, $foundKeys);

        if (empty($missingKeys)) {
            return null;
        } else {
            return sprintf('The edges refer to missing nodes "%s".', implode(', ', $missingKeys));
        }
    }
}
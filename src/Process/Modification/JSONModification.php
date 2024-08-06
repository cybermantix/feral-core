<?php

namespace Feral\Core\Process\Modification;

/**
 * Merge a modification into a configuration. If the _DELETE_
 * value is found in the context or nodes then remove them
 * from the configuration
 */
class JSONModification implements JSONModificationInterface
{

    /**
     * @inheritDoc
     */
    public function modify(string $configuration, string $modification): string
    {
        $configurationData = json_decode($configuration, true);
        $modificationData = json_decode($modification, true);

        // CLEAN
        foreach (self::DISALLOWED_PROPERTIES as $property) {
            unset($modificationData[$property]);
        }

        $finalData = array_merge_recursive($configurationData, $modificationData);

        // REMOVE CONTEXT VALUES
        foreach ($finalData['context'] as $key => $value) {
            if (self::DELETE == $value) {
                unset($finalData['context'][$key]);
            }
        }

        foreach ($finalData['nodes'] as $key => $node)  {
            if (self::DELETE == $node[self::DELETE_KEY]) {
                unset($finalData['nodes'][$key]);
            }
        }

        return json_encode($finalData);
    }
}
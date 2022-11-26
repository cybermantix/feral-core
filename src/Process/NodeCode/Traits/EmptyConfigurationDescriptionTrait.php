<?php

namespace NoLoCo\Core\Process\NodeCode\Traits;

/**
 * Add the function to return an empty array for the
 * configuration descriptions for Node Code classes
 * that don't need a configuration.
 */
trait EmptyConfigurationDescriptionTrait
{
    /**
     * No configuration options.
     *
     * @return array
     */
    public function getConfigurationDescriptions(): array
    {
        return [];
    }
}

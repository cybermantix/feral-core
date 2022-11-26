<?php

namespace NoLoCo\Core\Process\NodeCode\Configuration\Description;

/**
 * A configuration description that has options.
 */
interface OptionsDescriptionInterface
{
    /**
     * Get the valid options for the configuration.
     *
     * @return array
     */
    public function getOptions(): array;
}

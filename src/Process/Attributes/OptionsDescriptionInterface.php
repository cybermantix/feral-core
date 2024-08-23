<?php

namespace Feral\Core\Process\Attributes;

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

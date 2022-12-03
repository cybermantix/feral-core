<?php

namespace Nodez\Core\Process\NodeCode\Configuration;

use Nodez\Core\Process\NodeCode\Configuration\ValueModifier\ConfigurationValueModifierInterface;

/**
 * Build a configuration for a node instance. The configuration
 * value can be modified allowing secrets, database configuration values,
 * or other values that can be referenced with an identifier.
 */
class NodeConfigurationBuilder
{
    /**
     * The configuration that can be set in a node instance.
     *
     * @var array
     */
    protected array $subject;

    /**
     * An array of configuration value modifiers that can
     * modify the basic configuration value and replace it
     * with a processed value.
     *
     * @var ConfigurationValueModifierInterface[]
     */
    protected array $configurationValueModifiers;

    /**
     * @param ConfigurationValueModifierInterface[] $configurationValueModifiers
     */
    public function __construct(array $configurationValueModifiers = [])
    {
        $this->configurationValueModifiers = $configurationValueModifiers;
    }

    /**
     * Start the build processes with an existing configuration
     * array or an empty parameter to init with the default.
     *
     * @param  array|null $configuration
     * @return $this
     */
    public function init(array $configuration = null): static
    {
        if ($configuration) {
            $this->subject = $configuration;
        } else {
            $this->subject = [];
        }
        return $this;
    }

    /**
     * Add a value to the configuration array. Loop through the value
     * modifiers and if one accepts the value then process the value
     * modifier. Only process one value modifier.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return $this
     */
    public function addValue(string $key, mixed $value): static
    {
        foreach ($this->configurationValueModifiers as $modifier) {
            if ($modifier->accepts($value)) {
                $value = $modifier->modifyValue($value);
                break;
            }
        }
        $this->subject[$key] = $value;
        return $this;
    }

    /**
     * Return the configuration array that was built.
     *
     * @return array
     */
    public function build(): array
    {
        return $this->subject;
    }
}

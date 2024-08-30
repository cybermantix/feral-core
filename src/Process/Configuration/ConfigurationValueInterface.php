<?php

namespace Feral\Core\Process\Configuration;

/**
 * When a configuration value is set for the NodeCode or
 * CatalogNode it can contain secrets information that must
 * be explicitly called to get the value.
 */
interface ConfigurationValueInterface
{
    /**
     * @return string
     */
    public function getKey(): string;

    /**
     * @return mixed
     */
    public function getValue(): mixed;

    /**
     * @return mixed
     */
    public function getUnmaskedValue(): mixed;

    /**
     * @return bool
     */
    public function isSecret(): bool;
}
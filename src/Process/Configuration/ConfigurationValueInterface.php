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
    public function getDefault(): mixed;
    public function hasDefault(): bool;

    /**
     * @return bool
     */
    public function hasValue(): bool;

    /**
     * @return mixed
     */
    public function getUnmaskedValue(): mixed;

    /**
     * @return bool
     */
    public function isSecret(): bool;
}
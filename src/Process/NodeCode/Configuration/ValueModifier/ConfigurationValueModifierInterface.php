<?php

namespace Feral\Core\Process\NodeCode\Configuration\ValueModifier;

/**
 * When a configuration value is set into a node, the value
 * of the node can be interpreted and processed before being
 * set. The value of a configuration can be a key to another
 * value stored in a database or webservice.
 *
 * EX: if the value contained secret|abc123 the modifyValue
 * function can look up the secret by its key abc123 and
 * store the secret value.
 *
 * EX: if the value contained db|123 then the actual configuration
 * value is in the database and the value stored in the node
 * instance will be replaced with the value in the database.
 */
interface ConfigurationValueModifierInterface
{
    /**
     * The delimiter used to separate reference keys from
     * the reference type. For example, a configuration reference
     * might be stored as 'configuration|123' and the value
     * modifier for the configuration can change the value to the
     * one stored in the config.
     */
    public const REFERENCE_DELIMITER = '|';

    /**
     * Test weather the concrete implementation can modify
     * the value based on the current value.
     *
     * @param  mixed $value
     * @return bool
     */
    public function accepts(mixed $value): bool;

    /**
     * Provided the simple value from the configuration, allow
     * the concrete implementations to modify the value. A good
     * example of this would be to obscure secrets and use a
     * key to a secret instead of its actual secret providing
     * more security by not showing the secret itself in the
     * configuration.
     *
     * @param  mixed $value
     * @return mixed
     */
    public function modifyValue(mixed $value): mixed;
}

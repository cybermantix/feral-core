<?php

namespace NoLoCo\Core\Process\NodeCode;

use LogicException;
use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\Exception\MissingConfigurationValueException;
use NoLoCo\Core\Utility\Search\DataPathReaderInterface;
use NoLoCo\Core\Utility\Search\Exception\UnknownTypeException;

/**
 * The abstract class contains helper methods to get the local configuration
 * data.
 */
abstract class AbstractNodeCode implements NodeCodeInterface
{
    const MAX_MESSAGE_VALUE_LENGTH = 128;

    /**
     * The key used to identify this node and used to identify
     * the relationship in the graph edges
     * @var string
     */
    protected string $key;

    /**
     * AbstractNode constructor.
     * @param DataPathReaderInterface $dataPathReader
     * @param array $configuration
     */
    public function __construct(
        /**
         * The search object which will get data from the context.
         */
        protected DataPathReaderInterface $dataPathReader,
        /**
         * The configuration used in the algorithms in the concrete
         * node class.
         * @var string[]
         */
        protected array $configuration
    ){
    }

    /**
     * @param string $key
     * @return AbstractNodeCode
     */
    public function setKey(string $key): static
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @param array $configuration
     * @return AbstractNodeCode
     */
    public function setConfiguration(array $configuration): static
    {
        $this->configuration = $configuration;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }


    /**
     * @inheritDoc
     */
    public function addConfiguration(string $key, $value): static
    {
        if (!isset($this->configuration)) {
            $this->configuration = [];
        }
        $this->configuration[$key] = $value;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function mergeConfiguration(array $partialConfiguration): static
    {
        if (!isset($this->configuration)) {
            $this->configuration = $partialConfiguration;
        }
        $this->configuration = array_merge($this->configuration, $partialConfiguration);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Check if a configuration value is set for a key.
     * @param string $key
     * @return bool
     */
    protected function hasConfigurationValue(string $key): bool
    {
        if (!isset($this->configuration)) {
            throw new LogicException('The configuration is not set.');
        }
        return isset($this->configuration[$key]);
    }

    /**
     * A helper function to get the value of a configuration key
     * @param string $key
     * @param null $default
     * @return mixed
     */
    protected function getConfigurationValue(string $key, $default = null): mixed
    {
        if ($this->hasConfigurationValue($key)) {
            return $this->configuration[$key];
        } elseif(!is_null($default)) {
            return $default;
        } else {
            return null;
        }
    }

    /**
     * A helper function to get the value of a configuration key
     * @param string $key
     * @param null $default
     * @return mixed
     * @throws MissingConfigurationValueException
     */
    protected function getRequiredConfigurationValue(string $key, $default = null): mixed
    {
        if ($this->hasConfigurationValue($key)) {
            return $this->configuration[$key];
        } elseif($default) {
            return $default;
        } else {
            throw new MissingConfigurationValueException(sprintf(
                'The configuration is missing the required value for "%s".',
                $key
            ));
        }
    }

    /**
     * A helper function to get a configuration value as a boolean
     * @param string $key
     * @param bool|null $default
     * @return bool|null
     */
    protected function getBooleanConfigurationValue(string $key, bool $default = null): ?bool
    {
        return $this->getConfigurationValue($key, $default);
    }

    /**
     * A helper function to get a configuration value as a string
     * @param string $key
     * @param string|null $default
     * @return string|null
     */
    protected function getStringConfigurationValue(string $key, string $default = null): ?string
    {
        return $this->getConfigurationValue($key, $default);
    }

    /**
     * A helper function to get an int configuration value.
     * @param string $key
     * @param int|null $default
     * @return int|null
     */
    protected function getIntConfigurationValue(string $key, int $default = null): ?int
    {
        return $this->getConfigurationValue($key, $default);
    }


    /**
     * A helper function to get an array configuration value.
     * @param string $key
     * @param array|null $default
     * @return array|null
     */
    protected function getArrayConfigurationValue(string $key, array $default = null): ?array
    {
        return $this->getConfigurationValue($key, $default);
    }

    /**
     * A helper function to get a float configuration value
     * @param string $key
     * @param float|null $default
     * @return float|null
     */
    protected function getFloatConfigurationValue(string $key, float $default = null): ?float
    {
        return $this->getConfigurationValue($key, $default);
    }

    /**
     * A helper function to get a configuration value as a boolean
     * @param string $key
     * @param string|null $default
     * @return bool|null
     * @throws MissingConfigurationValueException
     */
    protected function getRequiredBooleanConfigurationValue(string $key, string $default = null): ?bool
    {
        return $this->getRequiredConfigurationValue($key, $default);
    }

    /**
     * A helper function to get a configuration value as a string
     * @param string $key
     * @param string|null $default
     * @return string|null
     */
    protected function getRequiredStringConfigurationValue(string $key, string $default = null): ?string
    {
        return $this->getRequiredConfigurationValue($key, $default);
    }

    /**
     * A helper function to get a required configuration value as an array
     * @param string $key
     * @param string|null $default
     * @return array|null
     * @throws MissingConfigurationValueException
     */
    protected function getRequiredArrayConfigurationValue(string $key, string $default = null): ?array
    {
        return $this->getRequiredConfigurationValue($key, $default);
    }

    /**
     * A helper function to get an int configuration value.
     * @param string $key
     * @param int|null $default
     * @return int|null
     * @throws MissingConfigurationValueException
     */
    protected function getRequiredIntConfigurationValue(string $key, int $default = null): ?int
    {
        return $this->getRequiredConfigurationValue($key, $default);
    }

    /**
     * A helper function to get a float configuration value
     * @param string $key
     * @param float|null $default
     * @return float|null
     */
    protected function getRequiredFloatConfigurationValue(string $key, float $default = null): ?float
    {
        return $this->getRequiredConfigurationValue($key, $default);
    }


    /**
     * A helper function to get a value from the context.
     * @param string $key
     * @param ContextInterface $context
     * @return mixed
     * @throws UnknownTypeException
     */
    protected function getValueFromContext(string $key, ContextInterface $context): mixed
    {
        return $this->dataPathReader->get($context, $key);
    }

    /**
     * A helper function to instantiate and set the values in the
     * results.
     * @param string $status
     * @param string $messageTemplate
     * @param array $variables
     * @return Result|ResultInterface
     */
    protected function result(string $status, string $messageTemplate = '', array $variables = [])
    {
        foreach ($variables as $key => $value) {
            if (is_array($value)) {
                $variables[$key] = print_r($value, true);
            } elseif (is_object($value)) {
                $variables[$key] = get_class($value);
            }
            if (self::MAX_MESSAGE_VALUE_LENGTH < strlen($variables[$key])) {
                $variables[$key] = substr($variables[$key], 0, self::MAX_MESSAGE_VALUE_LENGTH) . '...';
            }
        }

        $message = vsprintf($messageTemplate, $variables);
        return (new Result())
            ->setStatus($status)
            ->setMessage($message);
    }
}

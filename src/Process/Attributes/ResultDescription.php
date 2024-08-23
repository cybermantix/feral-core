<?php

namespace Feral\Core\Process\Attributes;
use Feral\Core\Process\Result\Description\ResultDescriptionInterface;

/**
 * @see ResultDescriptionInterface
 */
#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS)]
class ResultDescription implements ResultDescriptionInterface
{

    public function __construct(
        /**
         * The result returned by the node
         */
        private string $result,
        /**
         * The description of the result
         */
        private string $description
    ){}

    /**
     * @return string
     */
    public function getResult(): string
    {
        return $this->result;
    }

    /**
     * @param string $result
     * @return ResultDescription
     */
    public function setResult(string $result): ResultDescription
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return ResultDescription
     */
    public function setDescription(string $description): ResultDescription
    {
        $this->description = $description;
        return $this;
    }
}
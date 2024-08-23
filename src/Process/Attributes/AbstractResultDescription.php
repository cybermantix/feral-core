<?php

namespace Feral\Core\Process\Attributes;
use Feral\Core\Process\Result\Description\ResultDescriptionInterface;
use Feral\Core\Process\Result\ResultInterface;

/**
 * @see ResultDescriptionInterface
 */
abstract class AbstractResultDescription implements ResultDescriptionInterface
{
    public function __construct(
        /**
         * The result of the node process
         */
        protected string $result,
        /**
         * The description of the result
         */
        protected string $description
    ){ }

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
    public function setResult(string $result): AbstractResultDescription
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
    public function setDescription(string $description): AbstractResultDescription
    {
        $this->description = $description;
        return $this;
    }
}
<?php

namespace Feral\Core\Process\Attributes;
use Feral\Core\Process\Result\Description\ResultDescriptionInterface;
use Feral\Core\Process\Result\ResultInterface;

/**
 * @see ResultDescriptionInterface
 */
#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS)]
class OkResultDescription implements ResultDescriptionInterface
{

    public function __construct(
        /**
         * The description of the result
         */
        string $description = 'The node processing was successful.'
    ){
        parent::__construct(ResultInterface::OK, $this->description);
    }

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
    public function setResult(string $result): OkResultDescription
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
    public function setDescription(string $description): OkResultDescription
    {
        $this->description = $description;
        return $this;
    }
}
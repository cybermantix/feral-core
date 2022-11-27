<?php

namespace NoLoCo\Core\Process\Result\Description;
/**
 * @see ResultDescriptionInterface
 */
class ResultDescription implements ResultDescriptionInterface
{
    /**
     * The result returned by the node
     * @var string
     */
    private string $result;
    /**
     * The description of the result
     * @var string
     */
    private string $description;

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
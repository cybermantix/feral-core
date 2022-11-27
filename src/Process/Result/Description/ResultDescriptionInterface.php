<?php

namespace NoLoCo\Core\Process\Result\Description;
/**
 * A possible result from NodeCode. Provide the string result and
 * a description on why the result is a possibility.
 */
interface ResultDescriptionInterface
{
    /**
     * The string result from the node code.
     * @return string
     */
    public function getResult(): string;

    /**
     * The description of the result that describes
     * @return string
     */
    public function getDescription(): string;
}
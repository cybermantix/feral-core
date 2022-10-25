<?php

namespace NoLoCo\Core\Process\NodeCode\Traits;

use NoLoCo\Core\Process\Result\Result;
use NoLoCo\Core\Process\Result\ResultInterface;

trait ResultsTrait
{
    /**
     * The maximum length of a message. Any extra characters will
     * be truncated.
     * @var int
     */
    protected int $maxMessageValueLength = 128;

    /**
     * A helper function to instantiate and set the values in the
     * results.
     * @param string $status
     * @param string $messageTemplate
     * @param array $variables
     * @return ResultInterface
     */
    protected function result(string $status, string $messageTemplate = '', array $variables = []): ResultInterface
    {
        foreach ($variables as $key => $value) {
            if (is_array($value)) {
                $variables[$key] = print_r($value, true);
            } elseif (is_object($value)) {
                $variables[$key] = get_class($value);
            }
            if ($this->maxMessageValueLength < strlen($variables[$key])) {
                $variables[$key] = substr($variables[$key], 0, $this->maxMessageValueLength) . '...';
            }
        }

        $message = vsprintf($messageTemplate, $variables);
        return (new Result())
            ->setStatus($status)
            ->setMessage($message);
    }
}
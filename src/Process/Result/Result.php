<?php

namespace Feral\Core\Process\Result;

/**
 * A generic result returned from a node
 */
class Result implements ResultInterface
{
    /**
     * The result from the process node which is used
     * for flow control
     *
     * @var string
     */
    protected string $status;

    /**
     * The message from the process node which is used in the logging.
     *
     * @var string
     */
    protected string $message = '';

    /**
     * @inheritDoc
     */
    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @inheritDoc
     */
    public function setMessage(string $message): static
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}

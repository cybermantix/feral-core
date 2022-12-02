<?php

namespace NoLoCo\Core\Process\Result;

/**
 * After a node is processed it will return a result
 * object. The result is a string accompanied by a message.
 */
interface ResultInterface
{
    /**
     * The process has completed normally
     */
    const OK = 'ok';

    /**
     * This process skipped the main processing.
     */
    const SKIP = 'skip';

    /**
     * The process has completed normally and should not
     * continue processing.
     */
    const STOP = 'stop';

    /**
     * The process has completed but there was an issue but it
     * should continue to process.
     */
    const WARNING = 'warning';

    /**
     * The process has completed with an error and the process should
     * stop.
     */
    const ERROR = 'error';

    /**
     * The result of the process was true
     */
    const TRUE = 'true';

    /**
     * The result of the process was false
     */
    const FALSE = 'false';

    /**
     * The result of the process was the primary value
     */
    const PRIMARY = 'primary';

    /**
     * The result of the process was the secondary value
     */
    const SECONDARY = 'secondary';

    /**
     * The result of the process was the tertiary value
     */
    const TERTIARY = 'tertiary';

    /**
     * The result of the process was the low value
     */
    const LOW = 'low';

    /**
     * The result of the process was the medium value
     */
    const MEDIUM = 'medium';

    /**
     * The result of the process was the high value
     */
    const HIGH = 'high';

    /**
     * The result of the process was the grater than value
     */
    const GREATER_THAN = 'gt';

    /**
     * The result of the process was the greater than or equal value
     */
    const GREATER_THAN_EQUAL = 'gte';

    /**
     * The result of the process was the less than value
     */
    const LESS_THAN = 'lt';

    /**
     * The result of the process was the less than or equal value
     */
    const LESS_THAN_EQUAL = 'lte';

    /**
     * Set the status of the results which is used in flow control
     *
     * @param  string $status
     * @return $this
     */
    public function setStatus(string $status): static;

    /**
     * Get the status of the result which is used in flow control.
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Set the message which is used in logging.
     *
     * @param  string $message
     * @return $this
     */
    public function setMessage(string $message): static;

    /**
     * Get the message used in logging.
     *
     * @return string
     */
    public function getMessage(): string;
}

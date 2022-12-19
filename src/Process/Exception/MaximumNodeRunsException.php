<?php

namespace Feral\Core\Process\Exception;

use Exception;

/**
 * A cycle (possible endless loop) has been detected
 */
class MaximumNodeRunsException extends Exception
{
}

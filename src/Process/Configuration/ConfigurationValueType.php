<?php

namespace Feral\Core\Process\Configuration;

enum ConfigurationValueType
{
    case STANDARD;
    case SECRET;

    case OPTIONAL;
    case OPTIONAL_SECRET;
}

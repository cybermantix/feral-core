<?php

namespace Feral\Core\Utility\Filter\Adapter;

use Feral\Core\Utility\Filter\Filter;

interface AdapterInterface
{
    /**
     * Apply a filter to a set of data and allow the resulting set to be retrieved.
     *
     * @param  Filter $filter
     * @return static
     */
    public function apply(Filter $filter) : static;
}

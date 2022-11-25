<?php

namespace NoLoCo\Core\Utility\Filter;

/**
 * Class Order
 * A key/direction pair used to sort a set of data.
 * @package NoLoCo\Core\Utility\Entity\Filter
 */
class Order
{
    /**
     * Order in ascending value
     */
    const ASC = 'ASC';

    /**
     * Order in descending value
     */
    const DESC = 'DESC';

    /**
     * The field or set key for the sort
     * @var string
     */
    protected string $key;

    /**
     * The direction of the sort for this key
     * @var string
     */
    protected string $direction = self::ASC;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return Order
     */
    public function setKey(string $key): Order
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     * @return Order
     */
    public function setDirection(string $direction): Order
    {
        $this->direction = $direction;
        return $this;
    }
}

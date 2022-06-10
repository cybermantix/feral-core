<?php

namespace NoLoCo\Core\Utility\Filter;

use Symfony\Component\Serializer\Annotation as Serializer;
use OpenApi\Annotations as OA;

/**
 * Class Order
 * A key/direction pair used to sort a set of data.
 * @package App\Utility\Entity\Filter
 * @OA\Schema(
 *     description="The direction and key/property result data should be sorted by."
 * )
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
     * @Serializer\Groups("hydrate")
     * @OA\Property(
     *     description="The key or property to sort by."
     * )
     */
    protected string $key;

    /**
     * The direction of the sort for this key
     * @var string
     * @Serializer\Groups("hydrate")
     * @OA\Property(
     *     description="The direction the data should be filtered by."
     * )
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

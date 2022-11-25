<?php

namespace NoLoCo\Core\Utility\Filter;

/**
 * Class Filter
 * When using criteria to filter a set of data, the criteria will be "ANDED"
 * together unless there are multiple criterion for the same key.
 *
 * BOOLEAN EXAMPLES:
 *  1) Two different criterion keys
 *      WHERE foo = 'test' AND bar = 'test2'
 *
 *  2) Two similar criterion keys
 *      WHERE (foo >= 'test' OR foo <= 'test2')
 *
 *  3) Two similar criterion keys and one different key
 *      WHERE (foo >= 'test' OR foo <= 'test2') AND bar = 'test3'
 *
 * @package NoLoCo\Core\Utility\Entity
 */
class Filter
{
    /**
     * The default page for the result set.
     */
    const DEFAULT_PAGE = 1;

    /**
     * The default limit on the number of results in the result set
     */
    const DEFAULT_LIMIT = 50;

    /**
     * The page of results to return. Page 1 is the first page
     * which equates to offset 0;
     * @var int
     */
    protected int $page = self::DEFAULT_PAGE;

    /**
     * The number of results to return per page.
     * @var int
     */
    protected int $limit = self::DEFAULT_LIMIT;

    /**
     * An array of criteria used to filter a set of data. The data
     * is stored as an associative array with the field as the key
     * and the criterion as the value.
     * @var Criterion[]
     */
    protected array $criteria = [];

    /**
     * An array of criteria used to order a set of data.
     *
     * NOTE: WHEN TYPING THE PROPERTY "array" THE SERIALIZER DOES
     * NOT GET THE CLASS TYPE
     *
     * @var Order[]
     */
    protected array $orders = [];

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     * @return Filter
     */
    public function setPage(int $page): Filter
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     * @return Filter
     */
    public function setLimit(int $limit): Filter
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Get the offset of the the first result to return.
     * @return int
     */
    public function getResultIndex(): int
    {
        return ($this->page - 1) * $this->limit;
    }

    /**
     * @return Criterion[]
     */
    public function getCriteria(): array
    {
        return $this->criteria;
    }

    /**
     * @param Criterion[] $criteria
     * @return Filter
     */
    public function setCriteria(array $criteria): Filter
    {
        foreach ($criteria as $criterion) {
            $this->addCriteria($criterion);
        }
        return $this;
    }

    /**
     *
     * DO NOT USE SINGULAR "addCriterion" AS THE SERIALIZER
     * NEEDS THE SAME NAME AS THE PROPERTY!!!
     *
     * @param Criterion $criterion
     * @return Filter
     */
    public function addCriteria(Criterion $criterion): Filter
    {
        if (empty($this->criteria[$criterion->getKey()])) {
            $this->criteria[$criterion->getKey()] = [];
        }
        $this->criteria[$criterion->getKey()][] = $criterion;
        return $this;
    }

    /**
     * Remove all of the criteria for a key. This is used for
     * security reasons if a criteria key is being added
     * for a filtering reasons.
     * @param string $key
     * @return Filter
     */
    public function removeCriteria(string $key): Filter
    {
        $this->criteria[$key] = [];
        return $this;
    }

    /**
     * Get the array of orders.
     * @return Order[]
     */
    public function getOrders(): array
    {
        return $this->orders;
    }

    /**
     * Add an array of orders to the filter.
     * @param Order[] $orders
     * @return Filter
     */
    public function setOrders(array $orders): Filter
    {
        foreach ($orders as $value) {
            $this->addOrder($value);
        }
        return $this;
    }

    /**
     * A a single Order object to the filter.
     * @param Order $order
     * @return Filter
     */
    public function addOrder(Order $order): Filter
    {
        if (empty($this->orders[$order->getKey()])) {
            $this->orders[$order->getKey()] = [];
        }
        $this->orders[$order->getKey()] = $order;
        return $this;
    }

    /**
     * @param Order $order
     */
    public function removeOrders(Order $order): Filter
    {
        $index = array_search($order, $this->orders);
        if ($index !== false) {
            unset($this->orders[$index]);
        }
    }
}

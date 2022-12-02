<?php


namespace NoLoCo\Core\Utility\Filter\Adapter;

use NoLoCo\Core\Utility\Filter\Adapter\Exception\AdapterException;
use NoLoCo\Core\Utility\Filter\Comparator\Comparator;
use NoLoCo\Core\Utility\Filter\Comparator\ComparatorInterface;
use NoLoCo\Core\Utility\Filter\Comparator\Exception\UnknownComparatorException;
use NoLoCo\Core\Utility\Filter\Criterion;
use NoLoCo\Core\Utility\Filter\Filter;
use NoLoCo\Core\Utility\Filter\Order;

class ArrayAdapter implements AdapterInterface
{
    /**
     * The collection to be adapted
     *
     * @var array
     */
    protected array $originalData;

    /**
     * The adapted collection
     *
     * @var array|null
     */
    protected ?array $adaptedData;

    protected ComparatorInterface $comparator;

    public function __construct(ComparatorInterface $comparator = null)
    {
        if ($comparator) {
            $this->comparator = $comparator;
        } else {
            $this->comparator = new Comparator();
        }
    }

    /**
     * @return array|null
     */
    public function getArray(): ?array
    {
        return $this->adaptedData;
    }

    /**
     * @param  array $originalData
     * @return ArrayAdapter
     */
    public function setArray(array $originalData): self
    {
        $this->originalData = $originalData;
        return $this;
    }

    /**
     * @param  Filter $filter
     * @return ArrayAdapter
     * @throws UnknownComparatorException
     */
    public function apply(Filter $filter): static
    {
        $matches = false;
        // CRITERIA
        foreach ($filter->getCriteria() as $criterionArray) {
            if (1 < count($criterionArray)) {
                // IF ANY ARE TRUE THEN MATCH
                $internalMatch = false;
                foreach($criterionArray as $criterion) {
                    if ($this->compare($criterion->getOperator(), $this->originalData, $criterion->getValue())) {
                        $internalMatch = true;
                        break;
                    }
                }
                $matches = $internalMatch;
            } else {
                // IF ANY ARE FALSE THEN NO MATCH
                /**
 * @var Criterion $criterion 
*/
                $criterion = array_pop($criterionArray);
                if ($this->compare($criterion->getOperator(), $this->originalData, $criterion->getValue())) {
                    $matches = true;
                } else {
                    $matches = false;
                    break;
                }
            }
            if (!$matches) {
                break;
            }
        }

        if ($matches) {
            if (Criterion::BETWEEN == $criterion->getOperator()) {

            }
            $this->adaptedData = $this->originalData;
        } else {

            $this->adaptedData = null;
        }

        // ORDER
        $orders = $filter->getOrders();
        if ($order = array_shift($orders)) {
            if (Order::ASC == $order->getDirection()) {
                sort($this->adaptedData);
            } else {
                rsort($this->adaptedData);
            }
        }
        if(!empty($this->adaptedData)) {
            $this->adaptedData = array_slice($this->adaptedData, $filter->getResultIndex(), $filter->getLimit());
        }
        return $this;
    }

    /**
     * @param  $operator
     * @param  $value
     * @param  $testValue
     * @return bool
     * @throws UnknownComparatorException
     */
    protected function compare($operator, $value, $testValue): bool
    {
        if (strpos($testValue, Criterion::DELIMITER)) {
            $arrayTestValue = explode(Criterion::DELIMITER, $testValue);
            return $this->comparator->compare($value, $operator, $arrayTestValue);
        } else {
            return $this->comparator->compare($value, $operator, $testValue);
        }
    }
}

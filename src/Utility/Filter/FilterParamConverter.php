<?php


namespace NoLoCo\Core\Utility\Filter;

use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class FilterParamConverter implements ParamConverterInterface
{
    /**
     * @var FilterRequestParser
     */
    protected FilterRequestParser $requestParser;

    /**
     * @var FilterBuilder
     */
    protected FilterBuilder $builder;

    /**
     * FilterParamConverter constructor.
     * @param FilterRequestParser $requestParser
     * @param FilterBuilder $builder
     */
    public function __construct(FilterRequestParser $requestParser, FilterBuilder $builder)
    {
        $this->requestParser = $requestParser;
        $this->builder = $builder;
    }

    /**
     * @param Request $request
     * @param ParamConverter $configuration
     * @return bool|void
     * @throws Exception
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $this->requestParser->parse($request);
        $this->builder->init();
        $this->builder->withPage($this->requestParser->getPage());
        $this->builder->withLimit($this->requestParser->getLimit());
        foreach ($this->requestParser->getCriteria() as $criterionArray) {
            /** @var Criterion $criterion */
            foreach ($criterionArray as $criterion) {
                $this->builder->addCriteria($criterion->getKey(), $criterion->getOperator(), $criterion->getValue());
            }
        }
        foreach ($this->requestParser->getOrder() as $orderArray) {
            /** @var Order $order */
            foreach ($orderArray as $order) {
                $this->builder->addOrder($order->getKey(), $order->getDirection());
            }
        }
        $filter = $this->builder->build();
        $request->attributes->set($configuration->getName(), $filter);
    }

    /**
     * @param ParamConverter $configuration
     * @return bool
     */
    public function supports(ParamConverter $configuration)
    {
        if (is_a($configuration->getClass(), Filter::class, true)) {
            return true;
        }
    }
}

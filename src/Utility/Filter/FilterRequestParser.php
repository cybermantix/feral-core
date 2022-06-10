<?php


namespace NoLoCo\Core\Utility\Filter;

use Doctrine\DBAL\Types\Types;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use App\Utility\Rest\Groups;

/**
 * Class FilterRequestParser
 * Filter the request object and build a Filter object.
 * @package NoLoCo\Core\Utility\Filter
 */
class FilterRequestParser
{
    /**
     * The request parameter for the pagination page.
     */
    const KEY_PAGE = 'filter-page';

    /**
     * The request parameter for the pagination limit.
     */
    const KEY_LIMIT = 'filter-limit';

    /**
     * The request parameter for the filter criteria.
     */
    const KEY_FILTER = 'filter';

    /**
     * The request parameter for the order
     */
    const KEY_ORDER = 'order';

    /**
     * @var CriterionStringParserInterface
     */
    protected CriterionStringParserInterface $criterionParser;

    /**
     * @var OrderStringParserInterface
     */
    protected OrderStringParserInterface $orderParser;

    /**
     * @var SerializerInterface
     */
    protected SerializerInterface $serializer;

    /**
     * A two dimensional associative array containing
     * the criteria
     * @var array
     */
    protected array $criteria = [];

    /**
     * An associative array of of property names and direction
     * to be ordered.
     * @var array
     */
    protected array $order = [];

    /**
     * The pagination page to restrict the result set to
     * @var int
     */
    protected int $page = Filter::DEFAULT_PAGE;

    /**
     * The pagination value to limit the number of results
     * in the dataset.
     * @var int
     */
    protected int $limit = Filter::DEFAULT_LIMIT;

    /**
     * FilterRequestParser constructor.
     * @param CriterionStringParserInterface $criterionParser
     * @param OrderStringParserInterface $orderParser
     * @param SerializerInterface $serializer
     */
    public function __construct(
        CriterionStringParserInterface $criterionParser,
        OrderStringParserInterface $orderParser,
        SerializerInterface $serializer
    ) {
        $this->criterionParser = $criterionParser;
        $this->orderParser = $orderParser;
        $this->serializer = $serializer;
    }


    /**
     * @param Request $request
     * @return bool
     * @throws Exception\FilterParserException
     */
    public function parse(Request $request) : bool
    {
        $this->parseBody($request);
        $this->parseQuery($request);
        return true;
    }

    /**
     * @return array
     */
    public function getCriteria(): array
    {
        return $this->criteria;
    }

    /**
     * @return array
     */
    public function getOrder(): array
    {
        return $this->order;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param Request $request
     * @throws Exception\FilterParserException
     */
    protected function parseQuery(Request $request)
    {
        // PAGE
        if ($request->query->has(self::KEY_PAGE)){
            $raw = (int)$request->query->get(self::KEY_PAGE);
            if (0 < $raw) {
                $this->page = $raw;
            }
        }

        // LIMIT
        if ($request->query->has(self::KEY_LIMIT)){
            $raw = (int)$request->query->get(self::KEY_LIMIT);
            if (0 < $raw) {
                $this->limit = $raw;
            }
        }

        // CRITERIA
        if ($request->query->has(self::KEY_FILTER)){
            $filters = $request->query->get(self::KEY_FILTER);
            if (!is_array($filters)) {
                $filters = [$filters];
            }
            foreach ($filters as $filter) {
                $criterion = $this->criterionParser->parse($filter);
                $key = $criterion->getKey();
                if (empty($this->criteria[$key])) {
                    $this->criteria[$key] = [];
                }
                $this->criteria[$key][] = $criterion;
            }
        }

        // ORDER
        if ($request->query->has(self::KEY_ORDER)){
            $filterOrders = $request->query->get(self::KEY_ORDER);
            if (!is_array($filterOrders)) {
                $filterOrders = [$filterOrders];
            }
            foreach ($filterOrders as $filterOrder) {
                $order = $this->orderParser->parse($filterOrder);
                $key = $order->getKey();
                if (empty($this->order[$key])) {
                    $this->order[$key] = [];
                }
                $this->order[$key][] = $order;
            }
        }
    }

    protected function parseBody(Request $request)
    {
        $json = $request->getContent();
        if (empty($json)) {
            return;
        }
        /** @var Filter $filter */
        $filter = $this->serializer->deserialize(
            $json,
            Filter::class,
            Types::JSON,
            [AbstractNormalizer::GROUPS => [Groups::HYDRATE]]

        );
        if (!$filter) {
            return;
        }
        $page = $filter->getPage();
        if (0 < $page) {
            $this->page = $page;
        }
        $limit = $filter->getLimit();
        if (0 < $limit) {
            $this->limit = $limit;
        }
        $this->criteria += $filter->getCriteria();
        $this->order += $filter->getOrders();
    }
}

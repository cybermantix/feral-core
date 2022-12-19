<?php


namespace Feral\Core\Utility\Filter;

use Feral\Core\Utility\Filter\Exception\FilterParserException;

class OrderStringParser extends AbstractPeriscopeNotationParser implements OrderStringParserInterface
{
    /**
     * @inheritDoc
     */
    public function parse(string $orderString) : Order
    {
        list($key, $direction) = $this->parser->parseLeftBipartite($orderString);
        $upperDirection = strtoupper($direction);

        if (empty($key)) {
            throw new FilterParserException(
                sprintf(
                    'The key "%s" is invalid.',
                    $orderString
                )
            );
        }
        if (empty($direction) || !in_array($upperDirection, [Order::ASC, Order::DESC])) {
            throw new FilterParserException(
                sprintf(
                    'The direction "%s" is invalid.',
                    $orderString
                )
            );
        }
        return (new Order())
            ->setKey($key)
            ->setDirection($upperDirection);
    }
}

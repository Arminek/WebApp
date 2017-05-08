<?php

declare(strict_types=1);

namespace AppBundle\Search\Elastic\Factory\Query;

use AppBundle\Exception\MissingQueryParameterException;
use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\Query\TermLevel\RangeQuery;

final class ProductInPriceRangeQueryFactory implements QueryFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $parameters = []): BuilderInterface
    {
        $this->assertParameters($parameters);

        $graterThan = $parameters['product_price_range']['grater_than'];
        $lessThan = $parameters['product_price_range']['less_than'];

        return new RangeQuery('price.amount', ['gte' => $graterThan, 'lte' => $lessThan]);
    }

    /**
     * @param array $parameters
     *
     * @throws MissingQueryParameterException
     */
    private function assertParameters(array $parameters): void
    {
        if (!array_key_exists('product_price_range', $parameters)) {
            throw new MissingQueryParameterException('product_price_range', get_class($this));
        }

        if (!array_key_exists('grater_than', $parameters['product_price_range'])) {
            throw new MissingQueryParameterException('product_price_range.grater_than', get_class($this));
        }

        if (!array_key_exists('less_than', $parameters['product_price_range'])) {
            throw new MissingQueryParameterException('product_price_range.less_than', get_class($this));
        }
    }
}

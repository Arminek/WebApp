<?php

declare(strict_types=1);

namespace AppBundle\Search\Elastic\Factory\Query;

use AppBundle\Exception\MissingQueryParameterException;
use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\Query\FullText\MatchQuery;

final class MatchProductQueryFactory implements QueryFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $parameters = []): BuilderInterface
    {
        if (!isset($parameters['search']) || null == $parameters['search']) {
            throw new MissingQueryParameterException('search', get_class($this));
        }

        return new MatchQuery('title', $parameters['search']);
    }
}

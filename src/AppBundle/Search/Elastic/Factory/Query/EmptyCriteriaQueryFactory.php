<?php

declare(strict_types=1);

namespace AppBundle\Search\Elastic\Factory\Query;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;

final class EmptyCriteriaQueryFactory implements QueryFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $parameters = []): BuilderInterface
    {
        return new MatchAllQuery();
    }
}

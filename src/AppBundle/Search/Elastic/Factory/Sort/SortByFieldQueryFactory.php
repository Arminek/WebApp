<?php

declare(strict_types=1);

namespace AppBundle\Search\Elastic\Factory\Sort;

use AppBundle\Search\Criteria\Ordering;
use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\Sort\FieldSort;

final class SortByFieldQueryFactory implements SortFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(Ordering $ordering): BuilderInterface
    {
        return new FieldSort($ordering->field(), $ordering->direction());
    }
}

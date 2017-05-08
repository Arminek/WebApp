<?php

declare(strict_types=1);

namespace AppBundle\Search\Elastic\Factory\Sort;

use AppBundle\Search\Criteria\Ordering;
use ONGR\ElasticsearchDSL\BuilderInterface;

interface SortFactoryInterface
{
    /**
     * @param Ordering $ordering
     *
     * @return BuilderInterface
     */
    public function create(Ordering $ordering): BuilderInterface;
}

<?php

declare(strict_types=1);

namespace AppBundle\Search\Elastic\Applicator;

use AppBundle\Search\Criteria\Criteria;
use ONGR\ElasticsearchDSL\Search;

interface SearchCriteriaApplicatorInterface
{
    /**
     * @param Criteria $criteria
     * @param Search $search
     */
    public function apply(Criteria $criteria, Search $search): void;

    /**
     * @param Criteria $criteria
     *
     * @return bool
     */
    public function supports(Criteria $criteria): bool;
}

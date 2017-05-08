<?php

declare(strict_types=1);

namespace AppBundle\Search;

use AppBundle\Search\Criteria\Criteria;
use Porpaginas\Result;

interface SearchEngineInterface
{
    /**
     * @param Criteria $criteria
     *
     * @return Result
     */
    public function match(Criteria $criteria): Result;
}

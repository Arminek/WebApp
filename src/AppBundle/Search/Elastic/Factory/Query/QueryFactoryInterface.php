<?php

declare(strict_types=1);

namespace AppBundle\Search\Elastic\Factory\Query;

use AppBundle\Exception\MissingQueryParameterException;
use ONGR\ElasticsearchDSL\BuilderInterface;

interface QueryFactoryInterface
{
    /**
     * @param array $parameters
     *
     * @return BuilderInterface
     *
     * @throws MissingQueryParameterException
     */
    public function create(array $parameters = []): BuilderInterface;
}

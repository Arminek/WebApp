<?php

declare(strict_types=1);

namespace AppBundle\Search\Elastic;

use AppBundle\Search\Criteria\Criteria;
use AppBundle\Search\Elastic\Applicator\SearchCriteriaApplicatorInterface;
use AppBundle\Search\SearchEngineInterface;
use ONGR\ElasticsearchBundle\Service\Manager;
use Porpaginas\Arrays\ArrayResult;
use Porpaginas\Result;

final class ElasticSearchEngine implements SearchEngineInterface
{
    /**
     * @var Manager
     */
    private $manager;

    /**
     * @var SearchCriteriaApplicatorInterface[]
     */
    private $searchCriteriaApplicators = [];

    /**
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param SearchCriteriaApplicatorInterface $searchCriteriaApplicator
     */
    public function addSearchCriteriaApplicator(SearchCriteriaApplicatorInterface $searchCriteriaApplicator): void
    {
        $this->searchCriteriaApplicators[] = $searchCriteriaApplicator;
    }

    /**
     * {@inheritdoc}
     */
    public function match(Criteria $criteria): Result
    {
        $repository = $this->manager->getRepository($criteria->className());

        $search = $repository->createSearch();
        foreach ($this->searchCriteriaApplicators as $applicator) {
            if ($applicator->supports($criteria)) {
                $applicator->apply($criteria, $search);
            }
        }

        return new ArrayResult(iterator_to_array($repository->findArray($search)));
    }
}

<?php

declare(strict_types=1);

namespace spec\AppBundle\Search\Elastic;

use AppBundle\Search\Criteria\Criteria;
use AppBundle\Search\Elastic\Applicator\SearchCriteriaApplicatorInterface;
use AppBundle\Search\Elastic\ElasticSearchEngine;
use AppBundle\Search\SearchEngineInterface;
use ONGR\ElasticsearchBundle\Result\ArrayIterator;
use ONGR\ElasticsearchBundle\Service\Manager;
use ONGR\ElasticsearchBundle\Service\Repository;
use ONGR\ElasticsearchDSL\Search;
use PhpSpec\ObjectBehavior;
use Porpaginas\Arrays\ArrayResult;

final class ElasticSearchEngineSpec extends ObjectBehavior
{
    function let(Manager $manager): void
    {
        $this->beConstructedWith($manager);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ElasticSearchEngine::class);
    }

    function it_is_search_engine(): void
    {
        $this->shouldImplement(SearchEngineInterface::class);
    }

    function it_returns_paginator_with_default_query_if_there_is_no_builders_registered(
        Manager $manager,
        Search $search,
        Repository $repository,
        ArrayIterator $result
    ): void {
        $manager->getRepository('product')->willReturn($repository);
        $repository->createSearch()->willReturn($search);
        $search->toArray()->willReturn([
            'query' => [
                'match_all' => new \stdClass(),
            ]
        ]);

        $repository->findArray($search)->willReturn($result);
        $result->getRaw()->willReturn([]);

        $this->match(Criteria::fromQueryParameters('product', ['name' => 'banana']))->shouldBeLike(new ArrayResult([]));
    }

    function it_returns_resources_based_on_builders_which_supports_given_criteria(
        Manager $manager,
        Search $search,
        Repository $repository,
        ArrayIterator $result,
        SearchCriteriaApplicatorInterface $matchProductApplicator
    ): void {
        $criteria = Criteria::fromQueryParameters('product', ['name' => 'banana']);
        $this->addSearchCriteriaApplicator($matchProductApplicator);

        $matchProductApplicator->supports($criteria)->willReturn(true);
        $matchProductApplicator->apply($criteria, $search)->shouldBeCalled();

        $manager->getRepository('product')->willReturn($repository);
        $repository->createSearch()->willReturn($search);

        $search->toArray()->willReturn([
            'query' => [
                'match_all' => new \stdClass(),
            ]
        ]);

        $repository->findArray($search)->willReturn($result);
        $result->getRaw()->willReturn(['product']);

        $this->match($criteria)->shouldBeLike(new ArrayResult(['product']));
    }
}

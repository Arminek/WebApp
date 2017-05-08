<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Document\Product;
use AppBundle\Search\Criteria\Criteria;
use AppBundle\Search\SearchEngineInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class ProductCatalogueController
{
    /**
     * @var SearchEngineInterface
     */
    private $searchEngine;

    /**
     * @var ViewHandlerInterface
     */
    private $viewHandler;

    /**
     * @param SearchEngineInterface $searchEngine
     * @param ViewHandlerInterface $viewHandler
     */
    public function __construct(SearchEngineInterface $searchEngine, ViewHandlerInterface $viewHandler)
    {
        $this->searchEngine = $searchEngine;
        $this->viewHandler = $viewHandler;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function searchAction(Request $request): Response
    {
        try {
            $criteria = Criteria::fromQueryParameters(Product::class, $request->query->all());
            $result = $this->searchEngine->match($criteria);
        } catch (\Exception $exception) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'Something went wrong!', $exception);
        }

        $page = $result->take($criteria->paginating()->offset(), $criteria->paginating()->itemsPerPage());

        return $this->viewHandler->handle(View::create($page, Response::HTTP_OK));
    }
}

<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use Predis\ClientInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CartController
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function showAction(Request $request): Response
    {
        return new Response($this->client->get($request->get('id')));
    }
}

<?php

declare(strict_types=1);

namespace AppBundle\Document;

use ONGR\ElasticsearchBundle\Annotation as ElasticSearch;

/**
 * @ElasticSearch\Object
 */
final class Price
{
    /**
     * @var int
     *
     * @ElasticSearch\Property(type="integer")
     */
    private $amount;

    /**
     * @var string
     *
     * @ElasticSearch\Property(type="text")
     */
    private $currency;

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }
}

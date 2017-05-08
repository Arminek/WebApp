<?php

declare(strict_types=1);

namespace AppBundle\Search\Criteria;

final class Paginating
{
    const DEFAULT_CURRENT_PAGE = 1;
    const DEFAULT_ITEMS_PER_PAGE = 10;

    /**
     * @var int
     */
    private $currentPage;

    /**
     * @var int
     */
    private $itemsPerPage;

    /**
     * @var int
     */
    private $offset;

    /**
     * @param int $currentPage
     * @param int $itemsPerPage
     */
    private function __construct(int $currentPage, int $itemsPerPage)
    {
        $this->currentPage = $currentPage;
        if (0 >= $currentPage) {
            $this->currentPage = self::DEFAULT_CURRENT_PAGE;
        }

        $this->itemsPerPage = $itemsPerPage;
        if (0 >= $itemsPerPage) {
            $this->itemsPerPage = self::DEFAULT_ITEMS_PER_PAGE;
        }

        $this->offset = $this->currentPage * $this->itemsPerPage - $this->itemsPerPage;
    }

    /**
     * @param array $parameters
     *
     * @return Paginating
     */
    public static function fromQueryParameters(array $parameters): self
    {
        $currentPage = isset($parameters['page']) ? $parameters['page'] : self::DEFAULT_CURRENT_PAGE;
        $itemsPerPage = isset($parameters['per_page']) ? $parameters['per_page'] : self::DEFAULT_ITEMS_PER_PAGE;

        return new self((int) $currentPage, (int) $itemsPerPage);
    }

    /**
     * @return int
     */
    public function currentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    public function itemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    /**
     * @return int
     */
    public function offset(): int
    {
        return $this->offset;
    }
}

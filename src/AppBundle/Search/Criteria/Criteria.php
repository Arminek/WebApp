<?php

declare(strict_types=1);

namespace AppBundle\Search\Criteria;

final class Criteria
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var Paginating
     */
    private $paginating;

    /**
     * @var Ordering
     */
    private $ordering;

    /**
     * @var Filtering
     */
    private $filtering;

    /**
     * @param string $className
     * @param Paginating $paginating
     * @param Ordering $ordering
     * @param Filtering $filtering
     */
    private function __construct(string $className, Paginating $paginating, Ordering $ordering, Filtering $filtering)
    {
        $this->className = $className;
        $this->paginating = $paginating;
        $this->ordering = $ordering;
        $this->filtering = $filtering;
    }

    /**
     * @param string $className
     * @param array $parameters
     *
     * @return Criteria
     */
    public static function fromQueryParameters(string $className, array $parameters): self
    {
        $paginating = Paginating::fromQueryParameters($parameters);
        $ordering = Ordering::fromQueryParameters($parameters);
        $filtering = Filtering::fromQueryParameters($parameters);

        return new self($className, $paginating, $ordering, $filtering);
    }

    /**
     * @return string
     */
    public function className(): string
    {
        return $this->className;
    }

    /**
     * @return Paginating
     */
    public function paginating(): Paginating
    {
        return $this->paginating;
    }

    /**
     * @return Ordering
     */
    public function ordering(): Ordering
    {
        return $this->ordering;
    }

    /**
     * @return Filtering
     */
    public function filtering(): Filtering
    {
        return $this->filtering;
    }
}

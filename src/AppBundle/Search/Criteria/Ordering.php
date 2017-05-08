<?php

declare(strict_types=1);

namespace AppBundle\Search\Criteria;

final class Ordering
{
    const DEFAULT_FIELD = 'title';
    const DEFAULT_DIRECTION = self::ASCENDING_DIRECTION;
    const ASCENDING_DIRECTION = 'asc';
    const DESCENDING_DIRECTION = 'desc';

    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $direction;

    /**
     * @param string $field
     * @param string $direction
     */
    private function __construct(string $field, string $direction)
    {
        $this->field = $field;
        $this->direction = $direction;
    }

    /**
     * @param array $parameters
     *
     * @return Ordering
     */
    public static function fromQueryParameters(array $parameters): self
    {
        $field = isset($parameters['sort']) ? $parameters['sort'] : self::DEFAULT_FIELD;
        $direction = self::DEFAULT_DIRECTION;

        if ('-' === $field[0]) {
            $direction = self::DESCENDING_DIRECTION;
            $field = trim($field, '-');
        }

        return new self($field, $direction);
    }

    /**
     * @return string
     */
    public function field(): string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function direction(): string
    {
        return $this->direction;
    }
}

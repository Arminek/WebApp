<?php

declare(strict_types=1);

namespace AppBundle\Search\Criteria;

final class Filtering
{
    /**
     * @var array
     */
    private $fields;

    /**
     * @param array $fields
     */
    private function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * @param array $queryParameters
     *
     * @return Filtering
     */
    public static function fromQueryParameters(array $queryParameters): self
    {
        $fields = $queryParameters;

        unset($fields['page']);
        unset($fields['per_page']);
        unset($fields['sort']);

        return new self($fields);
    }

    /**
     * @return array
     */
    public function fields(): array
    {
        return $this->fields;
    }
}

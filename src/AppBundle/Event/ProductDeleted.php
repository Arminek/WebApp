<?php

declare(strict_types=1);

namespace AppBundle\Event;

final class ProductDeleted
{
    /**
     * @var int
     */
    private $id;

    /**
     * @param int $id
     */
    private function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @param array $data
     *
     * @return ProductDeleted
     */
    public static function deserialize(array $data): self
    {
        return new self($data['id']);
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }
}

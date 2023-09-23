<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Model;

final class ResultSet implements ResultSetInterface
{
    private array $objects;
    private Pagination $pagination;

    public function __construct(Pagination $pagination, array $objects = [])
    {
        $this->pagination = $pagination;
        $this->objects = $objects;
    }

    public function getObjects(): array
    {
        return $this->objects;
    }

    public function getPagination(): Pagination
    {
        return $this->pagination;
    }
}

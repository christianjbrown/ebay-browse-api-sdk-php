<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Model;

final class ResultSet implements ResultSetInterface
{
    private array $objects;
    private PaginationInterface $pagination;

    public function __construct(PaginationInterface $pagination, array $objects = [])
    {
        $this->pagination = $pagination;
        $this->objects = $objects;
    }

    public function getObjects(): array
    {
        return $this->objects;
    }

    public function getPagination(): PaginationInterface
    {
        return $this->pagination;
    }
}

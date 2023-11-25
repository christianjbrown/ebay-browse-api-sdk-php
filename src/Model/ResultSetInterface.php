<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Model;

interface ResultSetInterface
{
    public function getObjects(): array;

    public function getPagination(): PaginationInterface;
}

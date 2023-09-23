<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindService\Model;

interface ResultSetInterface
{
    public function getObjects(): array;

    public function getPagination(): Pagination;
}

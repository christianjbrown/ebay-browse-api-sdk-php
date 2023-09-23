<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Model;

interface PaginationInterface
{
    public function getEntriesPerPage(): int;

    public function getPageNumber(): int;

    public function getTotalEntries(): int;

    public function getTotalPages(): int;
}

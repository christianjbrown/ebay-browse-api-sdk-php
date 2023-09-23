<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Model;

final class Pagination implements PaginationInterface
{
    private int $entriesPerPage;
    private int $pageNumber;
    private int $totalEntries;
    private int $totalPages;

    public function __construct(int $totalEntries, int $pageNumber, int $entriesPerPage, int $totalPages)
    {
        $this->totalEntries = $totalEntries;
        $this->pageNumber = $pageNumber;
        $this->entriesPerPage = $entriesPerPage;
        $this->totalPages = $totalPages;
    }

    public function getEntriesPerPage(): int
    {
        return $this->entriesPerPage;
    }

    public function getPageNumber(): int
    {
        return $this->pageNumber;
    }

    public function getTotalEntries(): int
    {
        return $this->totalEntries;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }
}

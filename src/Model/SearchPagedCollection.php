<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class SearchPagedCollection implements SearchPagedCollectionInterface
{
    private ?AutoCorrectionsInterface $autoCorrections = null;
    private ?string $href = null;

    /**
     * @var array<int, ItemSummaryInterface>
     */
    private array $itemSummaries = [];
    private ?int $limit = null;
    private ?string $next = null;
    private ?int $offset = null;
    private ?string $prev = null;
    private ?RefinementInterface $refinement = null;
    private ?int $total = null;

    /**
     * @var array<int, ErrorInterface>
     */
    private array $warnings = [];

    public function getAutoCorrections(): ?AutoCorrectionsInterface
    {
        return $this->autoCorrections;
    }

    public function getHref(): ?string
    {
        return $this->href;
    }

    /**
     * @return array<int, ItemSummaryInterface>
     */
    public function getItemSummaries(): array
    {
        return $this->itemSummaries;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getNext(): ?string
    {
        return $this->next;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function getPrev(): ?string
    {
        return $this->prev;
    }

    public function getRefinement(): ?RefinementInterface
    {
        return $this->refinement;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    /**
     * @return array<int, ErrorInterface>
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

    public function setAutoCorrections(?AutoCorrectionsInterface $value): SearchPagedCollectionInterface
    {
        $this->autoCorrections = $value;

        return $this;
    }

    public function setHref(?string $value): SearchPagedCollectionInterface
    {
        $this->href = $value;

        return $this;
    }

    /**
     * @param array<int, ItemSummaryInterface> $value
     */
    public function setItemSummaries(array $value): SearchPagedCollectionInterface
    {
        $this->itemSummaries = $value;

        return $this;
    }

    public function setLimit(?int $value): SearchPagedCollectionInterface
    {
        $this->limit = $value;

        return $this;
    }

    public function setNext(?string $value): SearchPagedCollectionInterface
    {
        $this->next = $value;

        return $this;
    }

    public function setOffset(?int $value): SearchPagedCollectionInterface
    {
        $this->offset = $value;

        return $this;
    }

    public function setPrev(?string $value): SearchPagedCollectionInterface
    {
        $this->prev = $value;

        return $this;
    }

    public function setRefinement(?RefinementInterface $value): SearchPagedCollectionInterface
    {
        $this->refinement = $value;

        return $this;
    }

    public function setTotal(?int $value): SearchPagedCollectionInterface
    {
        $this->total = $value;

        return $this;
    }

    /**
     * @param array<int, ErrorInterface> $value
     */
    public function setWarnings(array $value): SearchPagedCollectionInterface
    {
        $this->warnings = $value;

        return $this;
    }
}

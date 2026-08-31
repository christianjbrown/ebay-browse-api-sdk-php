<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface SearchPagedCollectionInterface
{
    public function getAutoCorrections(): ?AutoCorrectionsInterface;

    public function getHref(): ?string;

    /**
     * @return array<int, ItemSummaryInterface>
     */
    public function getItemSummaries(): array;

    public function getLimit(): ?int;

    public function getNext(): ?string;

    public function getOffset(): ?int;

    public function getPrev(): ?string;

    public function getRefinement(): ?RefinementInterface;

    public function getTotal(): ?int;

    /**
     * @return array<int, ErrorInterface>
     */
    public function getWarnings(): array;

    public function setAutoCorrections(?AutoCorrectionsInterface $value): self;

    public function setHref(?string $value): self;

    /**
     * @param array<int, ItemSummaryInterface> $value
     */
    public function setItemSummaries(array $value): self;

    public function setLimit(?int $value): self;

    public function setNext(?string $value): self;

    public function setOffset(?int $value): self;

    public function setPrev(?string $value): self;

    public function setRefinement(?RefinementInterface $value): self;

    public function setTotal(?int $value): self;

    /**
     * @param array<int, ErrorInterface> $value
     */
    public function setWarnings(array $value): self;
}

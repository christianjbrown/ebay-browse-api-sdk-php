<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ItemGroupSummaryInterface
{
    /**
     * @return array<int, ImageInterface>
     */
    public function getItemGroupAdditionalImages(): array;

    public function getItemGroupHref(): ?string;

    public function getItemGroupId(): ?string;

    public function getItemGroupImage(): ?ImageInterface;

    public function getItemGroupTitle(): ?string;

    public function getItemGroupType(): ?string;

    /**
     * @param array<int, ImageInterface> $value
     */
    public function setItemGroupAdditionalImages(array $value): self;

    public function setItemGroupHref(?string $value): self;

    public function setItemGroupId(?string $value): self;

    public function setItemGroupImage(?ImageInterface $value): self;

    public function setItemGroupTitle(?string $value): self;

    public function setItemGroupType(?string $value): self;
}

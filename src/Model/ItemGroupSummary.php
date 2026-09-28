<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class ItemGroupSummary implements ItemGroupSummaryInterface
{
    /**
     * @var array<int, ImageInterface>
     */
    private array $itemGroupAdditionalImages = [];
    private ?string $itemGroupHref = null;
    private ?string $itemGroupId = null;
    private ?ImageInterface $itemGroupImage = null;
    private ?string $itemGroupTitle = null;
    private ?string $itemGroupType = null;

    /**
     * @return array<int, ImageInterface>
     */
    public function getItemGroupAdditionalImages(): array
    {
        return $this->itemGroupAdditionalImages;
    }

    public function getItemGroupHref(): ?string
    {
        return $this->itemGroupHref;
    }

    public function getItemGroupId(): ?string
    {
        return $this->itemGroupId;
    }

    public function getItemGroupImage(): ?ImageInterface
    {
        return $this->itemGroupImage;
    }

    public function getItemGroupTitle(): ?string
    {
        return $this->itemGroupTitle;
    }

    public function getItemGroupType(): ?string
    {
        return $this->itemGroupType;
    }

    /**
     * @param array<int, ImageInterface> $value
     */
    public function setItemGroupAdditionalImages(array $value): ItemGroupSummaryInterface
    {
        $this->itemGroupAdditionalImages = $value;

        return $this;
    }

    public function setItemGroupHref(?string $value): ItemGroupSummaryInterface
    {
        $this->itemGroupHref = $value;

        return $this;
    }

    public function setItemGroupId(?string $value): ItemGroupSummaryInterface
    {
        $this->itemGroupId = $value;

        return $this;
    }

    public function setItemGroupImage(?ImageInterface $value): ItemGroupSummaryInterface
    {
        $this->itemGroupImage = $value;

        return $this;
    }

    public function setItemGroupTitle(?string $value): ItemGroupSummaryInterface
    {
        $this->itemGroupTitle = $value;

        return $this;
    }

    public function setItemGroupType(?string $value): ItemGroupSummaryInterface
    {
        $this->itemGroupType = $value;

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ItemGroupSummary;
use ChristianBrown\EBay\Browse\Model\ItemGroupSummaryInterface;

use function is_array;
use function is_string;

final class ItemGroupSummaryTransformer implements ItemGroupSummaryTransformerInterface
{
    private ImagesTransformerInterface $imagesTransformer;
    private ImageTransformerInterface $imageTransformer;

    public function __construct(ImageTransformerInterface $imageTransformer, ImagesTransformerInterface $imagesTransformer)
    {
        $this->imageTransformer = $imageTransformer;
        $this->imagesTransformer = $imagesTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ItemGroupSummaryInterface
    {
        $itemGroupSummary = new ItemGroupSummary();

        $this->applyItemGroupAdditionalImages($itemGroupSummary, $data);
        self::applyItemGroupHref($itemGroupSummary, $data);
        self::applyItemGroupId($itemGroupSummary, $data);
        $this->applyItemGroupImage($itemGroupSummary, $data);
        self::applyItemGroupTitle($itemGroupSummary, $data);
        self::applyItemGroupType($itemGroupSummary, $data);

        return $itemGroupSummary;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyItemGroupAdditionalImages(ItemGroupSummary $itemGroupSummary, array $data): void
    {
        if (empty($data[self::KEY_ITEM_GROUP_ADDITIONAL_IMAGES])) {
            return;
        }
        if (!is_array($data[self::KEY_ITEM_GROUP_ADDITIONAL_IMAGES])) {
            return;
        }
        $itemGroupSummary->setItemGroupAdditionalImages($this->imagesTransformer->transform($data[self::KEY_ITEM_GROUP_ADDITIONAL_IMAGES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemGroupHref(ItemGroupSummary $itemGroupSummary, array $data): void
    {
        if (empty($data[self::KEY_ITEM_GROUP_HREF])) {
            return;
        }
        if (!is_string($data[self::KEY_ITEM_GROUP_HREF])) {
            return;
        }
        $itemGroupSummary->setItemGroupHref($data[self::KEY_ITEM_GROUP_HREF]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemGroupId(ItemGroupSummary $itemGroupSummary, array $data): void
    {
        if (empty($data[self::KEY_ITEM_GROUP_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ITEM_GROUP_ID])) {
            return;
        }
        $itemGroupSummary->setItemGroupId($data[self::KEY_ITEM_GROUP_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyItemGroupImage(ItemGroupSummary $itemGroupSummary, array $data): void
    {
        if (empty($data[self::KEY_ITEM_GROUP_IMAGE])) {
            return;
        }
        if (!is_array($data[self::KEY_ITEM_GROUP_IMAGE])) {
            return;
        }
        $itemGroupSummary->setItemGroupImage($this->imageTransformer->transform($data[self::KEY_ITEM_GROUP_IMAGE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemGroupTitle(ItemGroupSummary $itemGroupSummary, array $data): void
    {
        if (empty($data[self::KEY_ITEM_GROUP_TITLE])) {
            return;
        }
        if (!is_string($data[self::KEY_ITEM_GROUP_TITLE])) {
            return;
        }
        $itemGroupSummary->setItemGroupTitle($data[self::KEY_ITEM_GROUP_TITLE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemGroupType(ItemGroupSummary $itemGroupSummary, array $data): void
    {
        if (empty($data[self::KEY_ITEM_GROUP_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_ITEM_GROUP_TYPE])) {
            return;
        }
        $itemGroupSummary->setItemGroupType($data[self::KEY_ITEM_GROUP_TYPE]);
    }
}

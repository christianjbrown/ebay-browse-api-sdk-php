<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\Item;

use function is_array;

final class ItemProductTransformer implements ItemProductTransformerInterface
{
    private ItemGroupSummaryTransformerInterface $itemGroupSummaryTransformer;
    private ProductTransformerInterface $productTransformer;
    private ReviewRatingTransformerInterface $reviewRatingTransformer;

    public function __construct(ItemGroupSummaryTransformerInterface $itemGroupSummaryTransformer, ProductTransformerInterface $productTransformer, ReviewRatingTransformerInterface $reviewRatingTransformer)
    {
        $this->itemGroupSummaryTransformer = $itemGroupSummaryTransformer;
        $this->productTransformer = $productTransformer;
        $this->reviewRatingTransformer = $reviewRatingTransformer;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    public function apply(Item $item, array $data): void
    {
        $this->applyPrimaryItemGroup($item, $data);
        $this->applyPrimaryProductReviewRating($item, $data);
        $this->applyProduct($item, $data);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPrimaryItemGroup(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_PRIMARY_ITEM_GROUP])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_PRIMARY_ITEM_GROUP])) {
            return;
        }
        $item->setPrimaryItemGroup($this->itemGroupSummaryTransformer->transform($data[ItemTransformerInterface::KEY_PRIMARY_ITEM_GROUP]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPrimaryProductReviewRating(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_PRIMARY_PRODUCT_REVIEW_RATING])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_PRIMARY_PRODUCT_REVIEW_RATING])) {
            return;
        }
        $item->setPrimaryProductReviewRating($this->reviewRatingTransformer->transform($data[ItemTransformerInterface::KEY_PRIMARY_PRODUCT_REVIEW_RATING]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyProduct(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_PRODUCT])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_PRODUCT])) {
            return;
        }
        $item->setProduct($this->productTransformer->transform($data[ItemTransformerInterface::KEY_PRODUCT]));
    }
}

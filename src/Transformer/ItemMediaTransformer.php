<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\Item;

use function is_array;
use function is_string;

final class ItemMediaTransformer implements ItemMediaTransformerInterface
{
    private ImagesTransformerInterface $imagesTransformer;
    private ImageTransformerInterface $imageTransformer;

    public function __construct(ImageTransformerInterface $imageTransformer, ImagesTransformerInterface $imagesTransformer)
    {
        $this->imageTransformer = $imageTransformer;
        $this->imagesTransformer = $imagesTransformer;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    public function apply(Item $item, array $data): void
    {
        $this->applyAdditionalImages($item, $data);
        $this->applyImage($item, $data);
        self::applyItemAffiliateWebUrl($item, $data);
        self::applyItemWebUrl($item, $data);
        self::applyProductFicheWebUrl($item, $data);
        self::applyTyreLabelImageUrl($item, $data);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAdditionalImages(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_ADDITIONAL_IMAGES])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_ADDITIONAL_IMAGES])) {
            return;
        }
        $item->setAdditionalImages($this->imagesTransformer->transform($data[ItemTransformerInterface::KEY_ADDITIONAL_IMAGES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyImage(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_IMAGE])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_IMAGE])) {
            return;
        }
        $item->setImage($this->imageTransformer->transform($data[ItemTransformerInterface::KEY_IMAGE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemAffiliateWebUrl(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_ITEM_AFFILIATE_WEB_URL])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_ITEM_AFFILIATE_WEB_URL])) {
            return;
        }
        $item->setItemAffiliateWebUrl($data[ItemTransformerInterface::KEY_ITEM_AFFILIATE_WEB_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemWebUrl(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_ITEM_WEB_URL])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_ITEM_WEB_URL])) {
            return;
        }
        $item->setItemWebUrl($data[ItemTransformerInterface::KEY_ITEM_WEB_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyProductFicheWebUrl(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_PRODUCT_FICHE_WEB_URL])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_PRODUCT_FICHE_WEB_URL])) {
            return;
        }
        $item->setProductFicheWebUrl($data[ItemTransformerInterface::KEY_PRODUCT_FICHE_WEB_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTyreLabelImageUrl(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_TYRE_LABEL_IMAGE_URL])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_TYRE_LABEL_IMAGE_URL])) {
            return;
        }
        $item->setTyreLabelImageUrl($data[ItemTransformerInterface::KEY_TYRE_LABEL_IMAGE_URL]);
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\Product;
use ChristianBrown\EBay\Browse\Model\ProductInterface;

use function is_array;
use function is_string;

final class ProductTransformer implements ProductTransformerInterface
{
    private ImagesTransformerInterface $imagesTransformer;
    private ImageTransformerInterface $imageTransformer;
    private StringsTransformerInterface $stringsTransformer;

    public function __construct(ImageTransformerInterface $imageTransformer, ImagesTransformerInterface $imagesTransformer, StringsTransformerInterface $stringsTransformer)
    {
        $this->imageTransformer = $imageTransformer;
        $this->imagesTransformer = $imagesTransformer;
        $this->stringsTransformer = $stringsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ProductInterface
    {
        $product = new Product();

        $this->applyAdditionalImages($product, $data);
        self::applyBrand($product, $data);
        self::applyDescription($product, $data);
        $this->applyGtins($product, $data);
        $this->applyImage($product, $data);
        self::applyMpn($product, $data);
        self::applyTitle($product, $data);

        return $product;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAdditionalImages(Product $product, array $data): void
    {
        if (empty($data[self::KEY_ADDITIONAL_IMAGES])) {
            return;
        }
        if (!is_array($data[self::KEY_ADDITIONAL_IMAGES])) {
            return;
        }
        $product->setAdditionalImages($this->imagesTransformer->transform($data[self::KEY_ADDITIONAL_IMAGES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBrand(Product $product, array $data): void
    {
        if (empty($data[self::KEY_BRAND])) {
            return;
        }
        if (!is_string($data[self::KEY_BRAND])) {
            return;
        }
        $product->setBrand($data[self::KEY_BRAND]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(Product $product, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $product->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyGtins(Product $product, array $data): void
    {
        if (empty($data[self::KEY_GTINS])) {
            return;
        }
        if (!is_array($data[self::KEY_GTINS])) {
            return;
        }
        $product->setGtins($this->stringsTransformer->transform($data[self::KEY_GTINS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyImage(Product $product, array $data): void
    {
        if (empty($data[self::KEY_IMAGE])) {
            return;
        }
        if (!is_array($data[self::KEY_IMAGE])) {
            return;
        }
        $product->setImage($this->imageTransformer->transform($data[self::KEY_IMAGE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMpn(Product $product, array $data): void
    {
        if (empty($data[self::KEY_MPN])) {
            return;
        }
        if (!is_string($data[self::KEY_MPN])) {
            return;
        }
        $product->setMpn($data[self::KEY_MPN]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTitle(Product $product, array $data): void
    {
        if (empty($data[self::KEY_TITLE])) {
            return;
        }
        if (!is_string($data[self::KEY_TITLE])) {
            return;
        }
        $product->setTitle($data[self::KEY_TITLE]);
    }
}

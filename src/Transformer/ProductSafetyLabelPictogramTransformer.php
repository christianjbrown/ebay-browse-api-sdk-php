<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelPictogram;
use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelPictogramInterface;

use function is_string;

final class ProductSafetyLabelPictogramTransformer implements ProductSafetyLabelPictogramTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ProductSafetyLabelPictogramInterface
    {
        $productSafetyLabelPictogram = new ProductSafetyLabelPictogram();

        self::applyPictogramDescription($productSafetyLabelPictogram, $data);
        self::applyPictogramId($productSafetyLabelPictogram, $data);
        self::applyPictogramUrl($productSafetyLabelPictogram, $data);

        return $productSafetyLabelPictogram;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPictogramDescription(ProductSafetyLabelPictogram $productSafetyLabelPictogram, array $data): void
    {
        if (empty($data[self::KEY_PICTOGRAM_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_PICTOGRAM_DESCRIPTION])) {
            return;
        }
        $productSafetyLabelPictogram->setPictogramDescription($data[self::KEY_PICTOGRAM_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPictogramId(ProductSafetyLabelPictogram $productSafetyLabelPictogram, array $data): void
    {
        if (empty($data[self::KEY_PICTOGRAM_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_PICTOGRAM_ID])) {
            return;
        }
        $productSafetyLabelPictogram->setPictogramId($data[self::KEY_PICTOGRAM_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPictogramUrl(ProductSafetyLabelPictogram $productSafetyLabelPictogram, array $data): void
    {
        if (empty($data[self::KEY_PICTOGRAM_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_PICTOGRAM_URL])) {
            return;
        }
        $productSafetyLabelPictogram->setPictogramUrl($data[self::KEY_PICTOGRAM_URL]);
    }
}

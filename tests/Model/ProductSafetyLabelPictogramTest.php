<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelPictogram;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ProductSafetyLabelPictogram::class)]
final class ProductSafetyLabelPictogramTest extends TestCase
{
    public function test(): void
    {
        $productSafetyLabelPictogram = new ProductSafetyLabelPictogram();
        self::assertNull($productSafetyLabelPictogram->getPictogramDescription());
        self::assertNull($productSafetyLabelPictogram->getPictogramId());
        self::assertNull($productSafetyLabelPictogram->getPictogramUrl());

        self::assertSame($productSafetyLabelPictogram, $productSafetyLabelPictogram->setPictogramDescription('val_pictogramDescription'));
        self::assertSame($productSafetyLabelPictogram, $productSafetyLabelPictogram->setPictogramId('val_pictogramId'));
        self::assertSame($productSafetyLabelPictogram, $productSafetyLabelPictogram->setPictogramUrl('val_pictogramUrl'));

        self::assertSame('val_pictogramDescription', $productSafetyLabelPictogram->getPictogramDescription());
        self::assertSame('val_pictogramId', $productSafetyLabelPictogram->getPictogramId());
        self::assertSame('val_pictogramUrl', $productSafetyLabelPictogram->getPictogramUrl());
    }
}

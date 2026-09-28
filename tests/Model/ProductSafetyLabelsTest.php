<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelPictogramInterface;
use ChristianBrown\EBay\Browse\Model\ProductSafetyLabels;
use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelStatementInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ProductSafetyLabels::class)]
final class ProductSafetyLabelsTest extends TestCase
{
    public function test(): void
    {
        $pictograms = [self::createStub(ProductSafetyLabelPictogramInterface::class)];
        $statements = [self::createStub(ProductSafetyLabelStatementInterface::class)];

        $productSafetyLabels = new ProductSafetyLabels();
        self::assertSame([], $productSafetyLabels->getPictograms());
        self::assertSame([], $productSafetyLabels->getStatements());

        self::assertSame($productSafetyLabels, $productSafetyLabels->setPictograms($pictograms));
        self::assertSame($productSafetyLabels, $productSafetyLabels->setStatements($statements));

        self::assertSame($pictograms, $productSafetyLabels->getPictograms());
        self::assertSame($statements, $productSafetyLabels->getStatements());
    }
}

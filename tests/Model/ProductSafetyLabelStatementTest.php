<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelStatement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ProductSafetyLabelStatement::class)]
final class ProductSafetyLabelStatementTest extends TestCase
{
    public function test(): void
    {
        $productSafetyLabelStatement = new ProductSafetyLabelStatement();
        self::assertNull($productSafetyLabelStatement->getStatementDescription());
        self::assertNull($productSafetyLabelStatement->getStatementId());

        self::assertSame($productSafetyLabelStatement, $productSafetyLabelStatement->setStatementDescription('val_statementDescription'));
        self::assertSame($productSafetyLabelStatement, $productSafetyLabelStatement->setStatementId('val_statementId'));

        self::assertSame('val_statementDescription', $productSafetyLabelStatement->getStatementDescription());
        self::assertSame('val_statementId', $productSafetyLabelStatement->getStatementId());
    }
}

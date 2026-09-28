<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ProductIdentity;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ProductIdentity::class)]
final class ProductIdentityTest extends TestCase
{
    public function test(): void
    {
        $productIdentity = new ProductIdentity();
        self::assertNull($productIdentity->getIdentifierType());
        self::assertNull($productIdentity->getIdentifierValue());

        self::assertSame($productIdentity, $productIdentity->setIdentifierType('val_identifierType'));
        self::assertSame($productIdentity, $productIdentity->setIdentifierValue('val_identifierValue'));

        self::assertSame('val_identifierType', $productIdentity->getIdentifierType());
        self::assertSame('val_identifierValue', $productIdentity->getIdentifierValue());
    }
}

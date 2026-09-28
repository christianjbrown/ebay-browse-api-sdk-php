<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\SellerCustomPolicy;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SellerCustomPolicy::class)]
final class SellerCustomPolicyTest extends TestCase
{
    public function test(): void
    {
        $sellerCustomPolicy = new SellerCustomPolicy();
        self::assertNull($sellerCustomPolicy->getDescription());
        self::assertNull($sellerCustomPolicy->getLabel());
        self::assertNull($sellerCustomPolicy->getType());

        self::assertSame($sellerCustomPolicy, $sellerCustomPolicy->setDescription('val_description'));
        self::assertSame($sellerCustomPolicy, $sellerCustomPolicy->setLabel('val_label'));
        self::assertSame($sellerCustomPolicy, $sellerCustomPolicy->setType('val_type'));

        self::assertSame('val_description', $sellerCustomPolicy->getDescription());
        self::assertSame('val_label', $sellerCustomPolicy->getLabel());
        self::assertSame('val_type', $sellerCustomPolicy->getType());
    }
}

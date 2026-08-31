<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Enums;

use ChristianBrown\EBay\Browse\Enums\MarketplaceId;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MarketplaceId::class)]
final class MarketplaceIdTest extends TestCase
{
    public function testCasesAreBackedByTheirOwnName(): void
    {
        $cases = MarketplaceId::cases();

        self::assertCount(31, $cases);
        self::assertSame('EBAY_GB', MarketplaceId::EBAY_GB->value);
        self::assertSame(MarketplaceId::EBAY_US, MarketplaceId::from('EBAY_US'));
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\BuyingOptionDistribution;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BuyingOptionDistribution::class)]
final class BuyingOptionDistributionTest extends TestCase
{
    public function test(): void
    {
        $buyingOptionDistribution = new BuyingOptionDistribution();
        self::assertNull($buyingOptionDistribution->getBuyingOption());
        self::assertNull($buyingOptionDistribution->getMatchCount());
        self::assertNull($buyingOptionDistribution->getRefinementHref());

        self::assertSame($buyingOptionDistribution, $buyingOptionDistribution->setBuyingOption('v_51'));
        self::assertSame($buyingOptionDistribution, $buyingOptionDistribution->setMatchCount(152));
        self::assertSame($buyingOptionDistribution, $buyingOptionDistribution->setRefinementHref('v_53'));

        self::assertSame('v_51', $buyingOptionDistribution->getBuyingOption());
        self::assertSame(152, $buyingOptionDistribution->getMatchCount());
        self::assertSame('v_53', $buyingOptionDistribution->getRefinementHref());
    }
}

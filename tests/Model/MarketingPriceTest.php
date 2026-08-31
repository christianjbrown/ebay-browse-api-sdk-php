<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ConvertedAmountInterface;
use ChristianBrown\EBay\Browse\Model\MarketingPrice;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MarketingPrice::class)]
final class MarketingPriceTest extends TestCase
{
    public function test(): void
    {
        $discountAmount = self::createStub(ConvertedAmountInterface::class);
        $originalPrice = self::createStub(ConvertedAmountInterface::class);

        $marketingPrice = new MarketingPrice();
        self::assertNull($marketingPrice->getDiscountAmount());
        self::assertNull($marketingPrice->getDiscountPercentage());
        self::assertNull($marketingPrice->getOriginalPrice());
        self::assertNull($marketingPrice->getPriceTreatment());

        self::assertSame($marketingPrice, $marketingPrice->setDiscountAmount($discountAmount));
        self::assertSame($marketingPrice, $marketingPrice->setDiscountPercentage('v_52'));
        self::assertSame($marketingPrice, $marketingPrice->setOriginalPrice($originalPrice));
        self::assertSame($marketingPrice, $marketingPrice->setPriceTreatment('v_54'));

        self::assertSame($discountAmount, $marketingPrice->getDiscountAmount());
        self::assertSame('v_52', $marketingPrice->getDiscountPercentage());
        self::assertSame($originalPrice, $marketingPrice->getOriginalPrice());
        self::assertSame('v_54', $marketingPrice->getPriceTreatment());
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\AvailableCouponInterface;
use ChristianBrown\EBay\Browse\Model\ConvertedAmountInterface;
use ChristianBrown\EBay\Browse\Model\Item;
use ChristianBrown\EBay\Browse\Model\MarketingPriceInterface;
use ChristianBrown\EBay\Browse\Model\PaymentMethodInterface;
use ChristianBrown\EBay\Browse\Model\TaxInterface;
use ChristianBrown\EBay\Browse\Transformer\AvailableCouponsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ConvertedAmountTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemPricingTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\MarketingPriceTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\TaxesTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
#[CoversClass(ItemPricingTransformer::class)]
final class ItemPricingTransformerTest extends TestCase
{
    public function testApply(): void
    {
        $availableCouponsTransformerModel = self::createStub(AvailableCouponInterface::class);
        $availableCouponsTransformer = self::createStub(AvailableCouponsTransformerInterface::class);
        $availableCouponsTransformer->method('transform')->willReturn([$availableCouponsTransformerModel]);
        $stringsTransformerModel = 's';
        $stringsTransformer = self::createStub(StringsTransformerInterface::class);
        $stringsTransformer->method('transform')->willReturn([$stringsTransformerModel]);
        $convertedAmountTransformerModel = self::createStub(ConvertedAmountInterface::class);
        $convertedAmountTransformer = self::createStub(ConvertedAmountTransformerInterface::class);
        $convertedAmountTransformer->method('transform')->willReturn($convertedAmountTransformerModel);
        $marketingPriceTransformerModel = self::createStub(MarketingPriceInterface::class);
        $marketingPriceTransformer = self::createStub(MarketingPriceTransformerInterface::class);
        $marketingPriceTransformer->method('transform')->willReturn($marketingPriceTransformerModel);
        $paymentMethodsTransformerModel = self::createStub(PaymentMethodInterface::class);
        $paymentMethodsTransformer = self::createStub(PaymentMethodsTransformerInterface::class);
        $paymentMethodsTransformer->method('transform')->willReturn([$paymentMethodsTransformerModel]);
        $taxesTransformerModel = self::createStub(TaxInterface::class);
        $taxesTransformer = self::createStub(TaxesTransformerInterface::class);
        $taxesTransformer->method('transform')->willReturn([$taxesTransformerModel]);
        $data = [
            ItemTransformerInterface::KEY_AVAILABLE_COUPONS => ['raw_AvailableCoupons'],
            ItemTransformerInterface::KEY_BID_COUNT => 102,
            ItemTransformerInterface::KEY_BUYING_OPTIONS => ['raw_BuyingOptions'],
            ItemTransformerInterface::KEY_CURRENT_BID_PRICE => ['raw_CurrentBidPrice'],
            ItemTransformerInterface::KEY_ECO_PARTICIPATION_FEE => ['raw_EcoParticipationFee'],
            ItemTransformerInterface::KEY_MARKETING_PRICE => ['raw_MarketingPrice'],
            ItemTransformerInterface::KEY_MINIMUM_PRICE_TO_BID => ['raw_MinimumPriceToBid'],
            ItemTransformerInterface::KEY_PAYMENT_METHODS => ['raw_PaymentMethods'],
            ItemTransformerInterface::KEY_PRICE => ['raw_Price'],
            ItemTransformerInterface::KEY_PRICE_DISPLAY_CONDITION => 'v_10',
            ItemTransformerInterface::KEY_RESERVE_PRICE_MET => true,
            ItemTransformerInterface::KEY_TAXES => ['raw_Taxes'],
            ItemTransformerInterface::KEY_UNIQUE_BIDDER_COUNT => 113,
            ItemTransformerInterface::KEY_UNIT_PRICE => ['raw_UnitPrice'],
            ItemTransformerInterface::KEY_UNIT_PRICING_MEASURE => 'v_15',
        ];
        $item = new Item('v_0');

        $transformer = new ItemPricingTransformer($availableCouponsTransformer, $convertedAmountTransformer, $marketingPriceTransformer, $paymentMethodsTransformer, $stringsTransformer, $taxesTransformer);
        $transformer->apply($item, $data);

        self::assertSame([$availableCouponsTransformerModel], $item->getAvailableCoupons());
        self::assertSame(102, $item->getBidCount());
        self::assertSame([$stringsTransformerModel], $item->getBuyingOptions());
        self::assertSame($convertedAmountTransformerModel, $item->getCurrentBidPrice());
        self::assertSame($convertedAmountTransformerModel, $item->getEcoParticipationFee());
        self::assertSame($marketingPriceTransformerModel, $item->getMarketingPrice());
        self::assertSame($convertedAmountTransformerModel, $item->getMinimumPriceToBid());
        self::assertSame([$paymentMethodsTransformerModel], $item->getPaymentMethods());
        self::assertSame($convertedAmountTransformerModel, $item->getPrice());
        self::assertSame('v_10', $item->getPriceDisplayCondition());
        self::assertTrue($item->getReservePriceMet());
        self::assertSame([$taxesTransformerModel], $item->getTaxes());
        self::assertSame(113, $item->getUniqueBidderCount());
        self::assertSame($convertedAmountTransformerModel, $item->getUnitPrice());
        self::assertSame('v_15', $item->getUnitPricingMeasure());
    }

    public function testApplyLeavesTheItemUntouchedWhenNothingIsPresent(): void
    {
        $item = new Item('v_0');
        $transformer = new ItemPricingTransformer(self::createStub(AvailableCouponsTransformerInterface::class), self::createStub(ConvertedAmountTransformerInterface::class), self::createStub(MarketingPriceTransformerInterface::class), self::createStub(PaymentMethodsTransformerInterface::class), self::createStub(StringsTransformerInterface::class), self::createStub(TaxesTransformerInterface::class));

        $transformer->apply($item, []);

        self::assertSame(serialize(new Item('v_0')), serialize($item));
    }
}

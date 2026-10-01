<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\AvailableCouponInterface;
use ChristianBrown\EBay\Browse\Model\ConvertedAmountInterface;
use ChristianBrown\EBay\Browse\Model\Item;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
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
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
#[CoversClass(ItemPricingTransformer::class)]
final class ItemPricingTransformerTest extends TestCase
{
    private ?AvailableCouponInterface $availableCoupon = null;
    private ?ConvertedAmountInterface $convertedAmount = null;
    private ?MarketingPriceInterface $marketingPrice = null;
    private ?PaymentMethodInterface $paymentMethod = null;
    private ?TaxInterface $tax = null;

    public function testApply(): void
    {
        $data = [
            ItemTransformerInterface::KEY_AVAILABLE_COUPONS => ['raw_availableCoupons'],
            ItemTransformerInterface::KEY_BID_COUNT => 102,
            ItemTransformerInterface::KEY_BUYING_OPTIONS => ['raw_buyingOptions'],
            ItemTransformerInterface::KEY_CURRENT_BID_PRICE => ['raw_currentBidPrice'],
            ItemTransformerInterface::KEY_ECO_PARTICIPATION_FEE => ['raw_ecoParticipationFee'],
            ItemTransformerInterface::KEY_MARKETING_PRICE => ['raw_marketingPrice'],
            ItemTransformerInterface::KEY_MINIMUM_PRICE_TO_BID => ['raw_minimumPriceToBid'],
            ItemTransformerInterface::KEY_PAYMENT_METHODS => ['raw_paymentMethods'],
            ItemTransformerInterface::KEY_PRICE => ['raw_price'],
            ItemTransformerInterface::KEY_PRICE_DISPLAY_CONDITION => 'v_25',
            ItemTransformerInterface::KEY_RESERVE_PRICE_MET => true,
            ItemTransformerInterface::KEY_TAXES => ['raw_taxes'],
            ItemTransformerInterface::KEY_UNIQUE_BIDDER_COUNT => 137,
            ItemTransformerInterface::KEY_UNIT_PRICE => ['raw_unitPrice'],
            ItemTransformerInterface::KEY_UNIT_PRICING_MEASURE => 'v_38',
        ];

        $transformer = $this->buildTransformer();
        $actual = new Item('v_0');

        $transformer->apply($actual, $data);

        self::assertSame([$this->availableCoupon], $actual->getAvailableCoupons());
        self::assertSame(102, $actual->getBidCount());
        self::assertSame(['s'], $actual->getBuyingOptions());
        self::assertSame($this->convertedAmount, $actual->getCurrentBidPrice());
        self::assertSame($this->convertedAmount, $actual->getEcoParticipationFee());
        self::assertSame($this->marketingPrice, $actual->getMarketingPrice());
        self::assertSame($this->convertedAmount, $actual->getMinimumPriceToBid());
        self::assertSame([$this->paymentMethod], $actual->getPaymentMethods());
        self::assertSame($this->convertedAmount, $actual->getPrice());
        self::assertSame('v_25', $actual->getPriceDisplayCondition());
        self::assertTrue($actual->getReservePriceMet());
        self::assertSame([$this->tax], $actual->getTaxes());
        self::assertSame(137, $actual->getUniqueBidderCount());
        self::assertSame($this->convertedAmount, $actual->getUnitPrice());
        self::assertSame('v_38', $actual->getUnitPricingMeasure());
    }

    /**
     * @param array<string, mixed>         $data
     * @param Closure(ItemInterface): void $assert
     */
    #[DataProvider('provideApplyOptionalFieldStatesCases')]
    public function testApplyOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();
        $item = new Item('v_0');

        $transformer->apply($item, $data);

        $assert($item);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ItemInterface): void}>
     */
    public static function provideApplyOptionalFieldStatesCases(): iterable
    {
        $base = [ItemTransformerInterface::KEY_ITEM_ID => 'v_0'];

        yield 'allOptionalAbsent' => [
            [],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getAvailableCoupons());
                self::assertNull($model->getBidCount());
                self::assertSame([], $model->getBuyingOptions());
                self::assertNull($model->getCurrentBidPrice());
                self::assertNull($model->getEcoParticipationFee());
                self::assertNull($model->getMarketingPrice());
                self::assertNull($model->getMinimumPriceToBid());
                self::assertSame([], $model->getPaymentMethods());
                self::assertNull($model->getPrice());
                self::assertNull($model->getPriceDisplayCondition());
                self::assertNull($model->getReservePriceMet());
                self::assertSame([], $model->getTaxes());
                self::assertNull($model->getUniqueBidderCount());
                self::assertNull($model->getUnitPrice());
                self::assertNull($model->getUnitPricingMeasure());
            },
        ];

        yield 'availableCouponsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_AVAILABLE_COUPONS => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getAvailableCoupons());
            },
        ];

        yield 'bidCountWrongType' => [
            [...$base, ItemTransformerInterface::KEY_BID_COUNT => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getBidCount());
            },
        ];

        yield 'bidCountZero' => [
            [...$base, ItemTransformerInterface::KEY_BID_COUNT => 0],
            static function (ItemInterface $model): void {
                self::assertSame(0, $model->getBidCount());
            },
        ];

        yield 'buyingOptionsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_BUYING_OPTIONS => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getBuyingOptions());
            },
        ];

        yield 'currentBidPriceWrongType' => [
            [...$base, ItemTransformerInterface::KEY_CURRENT_BID_PRICE => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getCurrentBidPrice());
            },
        ];

        yield 'ecoParticipationFeeWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ECO_PARTICIPATION_FEE => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getEcoParticipationFee());
            },
        ];

        yield 'marketingPriceWrongType' => [
            [...$base, ItemTransformerInterface::KEY_MARKETING_PRICE => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getMarketingPrice());
            },
        ];

        yield 'minimumPriceToBidWrongType' => [
            [...$base, ItemTransformerInterface::KEY_MINIMUM_PRICE_TO_BID => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getMinimumPriceToBid());
            },
        ];

        yield 'paymentMethodsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_PAYMENT_METHODS => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getPaymentMethods());
            },
        ];

        yield 'priceWrongType' => [
            [...$base, ItemTransformerInterface::KEY_PRICE => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getPrice());
            },
        ];

        yield 'priceDisplayConditionWrongType' => [
            [...$base, ItemTransformerInterface::KEY_PRICE_DISPLAY_CONDITION => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getPriceDisplayCondition());
            },
        ];

        yield 'reservePriceMetWrongType' => [
            [...$base, ItemTransformerInterface::KEY_RESERVE_PRICE_MET => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getReservePriceMet());
            },
        ];

        yield 'reservePriceMetFalse' => [
            [...$base, ItemTransformerInterface::KEY_RESERVE_PRICE_MET => false],
            static function (ItemInterface $model): void {
                self::assertFalse($model->getReservePriceMet());
            },
        ];

        yield 'taxesWrongType' => [
            [...$base, ItemTransformerInterface::KEY_TAXES => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getTaxes());
            },
        ];

        yield 'uniqueBidderCountWrongType' => [
            [...$base, ItemTransformerInterface::KEY_UNIQUE_BIDDER_COUNT => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getUniqueBidderCount());
            },
        ];

        yield 'uniqueBidderCountZero' => [
            [...$base, ItemTransformerInterface::KEY_UNIQUE_BIDDER_COUNT => 0],
            static function (ItemInterface $model): void {
                self::assertSame(0, $model->getUniqueBidderCount());
            },
        ];

        yield 'unitPriceWrongType' => [
            [...$base, ItemTransformerInterface::KEY_UNIT_PRICE => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getUnitPrice());
            },
        ];

        yield 'unitPricingMeasureWrongType' => [
            [...$base, ItemTransformerInterface::KEY_UNIT_PRICING_MEASURE => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getUnitPricingMeasure());
            },
        ];
    }

    private function buildTransformer(): ItemPricingTransformer
    {
        $this->availableCoupon = self::createStub(AvailableCouponInterface::class);
        $this->convertedAmount = self::createStub(ConvertedAmountInterface::class);
        $this->marketingPrice = self::createStub(MarketingPriceInterface::class);
        $this->paymentMethod = self::createStub(PaymentMethodInterface::class);
        $this->tax = self::createStub(TaxInterface::class);

        $availableCouponsTransformer = self::createStub(AvailableCouponsTransformerInterface::class);
        $availableCouponsTransformer->method('transform')->willReturn([$this->availableCoupon]);
        $convertedAmountTransformer = self::createStub(ConvertedAmountTransformerInterface::class);
        $convertedAmountTransformer->method('transform')->willReturn($this->convertedAmount);
        $marketingPriceTransformer = self::createStub(MarketingPriceTransformerInterface::class);
        $marketingPriceTransformer->method('transform')->willReturn($this->marketingPrice);
        $paymentMethodsTransformer = self::createStub(PaymentMethodsTransformerInterface::class);
        $paymentMethodsTransformer->method('transform')->willReturn([$this->paymentMethod]);
        $stringsTransformer = self::createStub(StringsTransformerInterface::class);
        $stringsTransformer->method('transform')->willReturn(['s']);
        $taxesTransformer = self::createStub(TaxesTransformerInterface::class);
        $taxesTransformer->method('transform')->willReturn([$this->tax]);

        return new ItemPricingTransformer($availableCouponsTransformer, $convertedAmountTransformer, $marketingPriceTransformer, $paymentMethodsTransformer, $stringsTransformer, $taxesTransformer);
    }
}

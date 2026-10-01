<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\AddonServiceInterface;
use ChristianBrown\EBay\Browse\Model\EstimatedAvailabilityInterface;
use ChristianBrown\EBay\Browse\Model\Item;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use ChristianBrown\EBay\Browse\Model\ItemLocationInterface;
use ChristianBrown\EBay\Browse\Model\ReturnTermsInterface;
use ChristianBrown\EBay\Browse\Model\ShippingOptionInterface;
use ChristianBrown\EBay\Browse\Model\ShipToLocationsInterface;
use ChristianBrown\EBay\Browse\Transformer\AddonServicesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\EstimatedAvailabilitiesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemFulfilmentTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemLocationTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ReturnTermsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ShippingOptionsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ShipToLocationsTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
#[CoversClass(ItemFulfilmentTransformer::class)]
final class ItemFulfilmentTransformerTest extends TestCase
{
    private ?AddonServiceInterface $addonService = null;
    private ?EstimatedAvailabilityInterface $estimatedAvailability = null;
    private ?ItemLocationInterface $itemLocation = null;
    private ?ReturnTermsInterface $returnTerms = null;
    private ?ShippingOptionInterface $shippingOption = null;
    private ?ShipToLocationsInterface $shipToLocations = null;

    public function testApply(): void
    {
        $data = [
            ItemTransformerInterface::KEY_ADDON_SERVICES => ['raw_addonServices'],
            ItemTransformerInterface::KEY_ELIGIBLE_FOR_INLINE_CHECKOUT => true,
            ItemTransformerInterface::KEY_ENABLED_FOR_GUEST_CHECKOUT => true,
            ItemTransformerInterface::KEY_ESTIMATED_AVAILABILITIES => ['raw_estimatedAvailabilities'],
            ItemTransformerInterface::KEY_IMMEDIATE_PAY => true,
            ItemTransformerInterface::KEY_ITEM_LOCATION => ['raw_itemLocation'],
            ItemTransformerInterface::KEY_PRIORITY_LISTING => true,
            ItemTransformerInterface::KEY_QUANTITY_LIMIT_PER_BUYER => 127,
            ItemTransformerInterface::KEY_RETURN_TERMS => ['raw_returnTerms'],
            ItemTransformerInterface::KEY_SHIPPING_OPTIONS => ['raw_shippingOptions'],
            ItemTransformerInterface::KEY_SHIP_TO_LOCATIONS => ['raw_shipToLocations'],
            ItemTransformerInterface::KEY_TOP_RATED_BUYING_EXPERIENCE => true,
        ];

        $transformer = $this->buildTransformer();
        $actual = new Item('v_0');

        $transformer->apply($actual, $data);

        self::assertSame([$this->addonService], $actual->getAddonServices());
        self::assertTrue($actual->getEligibleForInlineCheckout());
        self::assertTrue($actual->getEnabledForGuestCheckout());
        self::assertSame([$this->estimatedAvailability], $actual->getEstimatedAvailabilities());
        self::assertTrue($actual->getImmediatePay());
        self::assertSame($this->itemLocation, $actual->getItemLocation());
        self::assertTrue($actual->getPriorityListing());
        self::assertSame(127, $actual->getQuantityLimitPerBuyer());
        self::assertSame($this->returnTerms, $actual->getReturnTerms());
        self::assertSame([$this->shippingOption], $actual->getShippingOptions());
        self::assertSame($this->shipToLocations, $actual->getShipToLocations());
        self::assertTrue($actual->getTopRatedBuyingExperience());
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
                self::assertSame([], $model->getAddonServices());
                self::assertNull($model->getEligibleForInlineCheckout());
                self::assertNull($model->getEnabledForGuestCheckout());
                self::assertSame([], $model->getEstimatedAvailabilities());
                self::assertNull($model->getImmediatePay());
                self::assertNull($model->getItemLocation());
                self::assertNull($model->getPriorityListing());
                self::assertNull($model->getQuantityLimitPerBuyer());
                self::assertNull($model->getReturnTerms());
                self::assertSame([], $model->getShippingOptions());
                self::assertNull($model->getShipToLocations());
                self::assertNull($model->getTopRatedBuyingExperience());
            },
        ];

        yield 'addonServicesWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ADDON_SERVICES => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getAddonServices());
            },
        ];

        yield 'eligibleForInlineCheckoutWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ELIGIBLE_FOR_INLINE_CHECKOUT => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getEligibleForInlineCheckout());
            },
        ];

        yield 'eligibleForInlineCheckoutFalse' => [
            [...$base, ItemTransformerInterface::KEY_ELIGIBLE_FOR_INLINE_CHECKOUT => false],
            static function (ItemInterface $model): void {
                self::assertFalse($model->getEligibleForInlineCheckout());
            },
        ];

        yield 'enabledForGuestCheckoutWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ENABLED_FOR_GUEST_CHECKOUT => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getEnabledForGuestCheckout());
            },
        ];

        yield 'enabledForGuestCheckoutFalse' => [
            [...$base, ItemTransformerInterface::KEY_ENABLED_FOR_GUEST_CHECKOUT => false],
            static function (ItemInterface $model): void {
                self::assertFalse($model->getEnabledForGuestCheckout());
            },
        ];

        yield 'estimatedAvailabilitiesWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ESTIMATED_AVAILABILITIES => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getEstimatedAvailabilities());
            },
        ];

        yield 'immediatePayWrongType' => [
            [...$base, ItemTransformerInterface::KEY_IMMEDIATE_PAY => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getImmediatePay());
            },
        ];

        yield 'immediatePayFalse' => [
            [...$base, ItemTransformerInterface::KEY_IMMEDIATE_PAY => false],
            static function (ItemInterface $model): void {
                self::assertFalse($model->getImmediatePay());
            },
        ];

        yield 'itemLocationWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ITEM_LOCATION => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getItemLocation());
            },
        ];

        yield 'priorityListingWrongType' => [
            [...$base, ItemTransformerInterface::KEY_PRIORITY_LISTING => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getPriorityListing());
            },
        ];

        yield 'priorityListingFalse' => [
            [...$base, ItemTransformerInterface::KEY_PRIORITY_LISTING => false],
            static function (ItemInterface $model): void {
                self::assertFalse($model->getPriorityListing());
            },
        ];

        yield 'quantityLimitPerBuyerWrongType' => [
            [...$base, ItemTransformerInterface::KEY_QUANTITY_LIMIT_PER_BUYER => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getQuantityLimitPerBuyer());
            },
        ];

        yield 'quantityLimitPerBuyerZero' => [
            [...$base, ItemTransformerInterface::KEY_QUANTITY_LIMIT_PER_BUYER => 0],
            static function (ItemInterface $model): void {
                self::assertSame(0, $model->getQuantityLimitPerBuyer());
            },
        ];

        yield 'returnTermsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_RETURN_TERMS => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getReturnTerms());
            },
        ];

        yield 'shippingOptionsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SHIPPING_OPTIONS => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getShippingOptions());
            },
        ];

        yield 'shipToLocationsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SHIP_TO_LOCATIONS => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getShipToLocations());
            },
        ];

        yield 'topRatedBuyingExperienceWrongType' => [
            [...$base, ItemTransformerInterface::KEY_TOP_RATED_BUYING_EXPERIENCE => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getTopRatedBuyingExperience());
            },
        ];

        yield 'topRatedBuyingExperienceFalse' => [
            [...$base, ItemTransformerInterface::KEY_TOP_RATED_BUYING_EXPERIENCE => false],
            static function (ItemInterface $model): void {
                self::assertFalse($model->getTopRatedBuyingExperience());
            },
        ];
    }

    private function buildTransformer(): ItemFulfilmentTransformer
    {
        $this->addonService = self::createStub(AddonServiceInterface::class);
        $this->estimatedAvailability = self::createStub(EstimatedAvailabilityInterface::class);
        $this->itemLocation = self::createStub(ItemLocationInterface::class);
        $this->returnTerms = self::createStub(ReturnTermsInterface::class);
        $this->shipToLocations = self::createStub(ShipToLocationsInterface::class);
        $this->shippingOption = self::createStub(ShippingOptionInterface::class);

        $addonServicesTransformer = self::createStub(AddonServicesTransformerInterface::class);
        $addonServicesTransformer->method('transform')->willReturn([$this->addonService]);
        $estimatedAvailabilitiesTransformer = self::createStub(EstimatedAvailabilitiesTransformerInterface::class);
        $estimatedAvailabilitiesTransformer->method('transform')->willReturn([$this->estimatedAvailability]);
        $itemLocationTransformer = self::createStub(ItemLocationTransformerInterface::class);
        $itemLocationTransformer->method('transform')->willReturn($this->itemLocation);
        $returnTermsTransformer = self::createStub(ReturnTermsTransformerInterface::class);
        $returnTermsTransformer->method('transform')->willReturn($this->returnTerms);
        $shipToLocationsTransformer = self::createStub(ShipToLocationsTransformerInterface::class);
        $shipToLocationsTransformer->method('transform')->willReturn($this->shipToLocations);
        $shippingOptionsTransformer = self::createStub(ShippingOptionsTransformerInterface::class);
        $shippingOptionsTransformer->method('transform')->willReturn([$this->shippingOption]);

        return new ItemFulfilmentTransformer($addonServicesTransformer, $estimatedAvailabilitiesTransformer, $itemLocationTransformer, $returnTermsTransformer, $shipToLocationsTransformer, $shippingOptionsTransformer);
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\AddonServiceInterface;
use ChristianBrown\EBay\Browse\Model\EstimatedAvailabilityInterface;
use ChristianBrown\EBay\Browse\Model\Item;
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
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
#[CoversClass(ItemFulfilmentTransformer::class)]
final class ItemFulfilmentTransformerTest extends TestCase
{
    public function testApply(): void
    {
        $addonServicesTransformerModel = self::createStub(AddonServiceInterface::class);
        $addonServicesTransformer = self::createStub(AddonServicesTransformerInterface::class);
        $addonServicesTransformer->method('transform')->willReturn([$addonServicesTransformerModel]);
        $estimatedAvailabilitiesTransformerModel = self::createStub(EstimatedAvailabilityInterface::class);
        $estimatedAvailabilitiesTransformer = self::createStub(EstimatedAvailabilitiesTransformerInterface::class);
        $estimatedAvailabilitiesTransformer->method('transform')->willReturn([$estimatedAvailabilitiesTransformerModel]);
        $itemLocationTransformerModel = self::createStub(ItemLocationInterface::class);
        $itemLocationTransformer = self::createStub(ItemLocationTransformerInterface::class);
        $itemLocationTransformer->method('transform')->willReturn($itemLocationTransformerModel);
        $returnTermsTransformerModel = self::createStub(ReturnTermsInterface::class);
        $returnTermsTransformer = self::createStub(ReturnTermsTransformerInterface::class);
        $returnTermsTransformer->method('transform')->willReturn($returnTermsTransformerModel);
        $shippingOptionsTransformerModel = self::createStub(ShippingOptionInterface::class);
        $shippingOptionsTransformer = self::createStub(ShippingOptionsTransformerInterface::class);
        $shippingOptionsTransformer->method('transform')->willReturn([$shippingOptionsTransformerModel]);
        $shipToLocationsTransformerModel = self::createStub(ShipToLocationsInterface::class);
        $shipToLocationsTransformer = self::createStub(ShipToLocationsTransformerInterface::class);
        $shipToLocationsTransformer->method('transform')->willReturn($shipToLocationsTransformerModel);
        $data = [
            ItemTransformerInterface::KEY_ADDON_SERVICES => ['raw_AddonServices'],
            ItemTransformerInterface::KEY_ELIGIBLE_FOR_INLINE_CHECKOUT => true,
            ItemTransformerInterface::KEY_ENABLED_FOR_GUEST_CHECKOUT => true,
            ItemTransformerInterface::KEY_ESTIMATED_AVAILABILITIES => ['raw_EstimatedAvailabilities'],
            ItemTransformerInterface::KEY_IMMEDIATE_PAY => true,
            ItemTransformerInterface::KEY_ITEM_LOCATION => ['raw_ItemLocation'],
            ItemTransformerInterface::KEY_PRIORITY_LISTING => true,
            ItemTransformerInterface::KEY_QUANTITY_LIMIT_PER_BUYER => 108,
            ItemTransformerInterface::KEY_RETURN_TERMS => ['raw_ReturnTerms'],
            ItemTransformerInterface::KEY_SHIPPING_OPTIONS => ['raw_ShippingOptions'],
            ItemTransformerInterface::KEY_SHIP_TO_LOCATIONS => ['raw_ShipToLocations'],
            ItemTransformerInterface::KEY_TOP_RATED_BUYING_EXPERIENCE => true,
        ];
        $item = new Item('v_0');

        $transformer = new ItemFulfilmentTransformer($addonServicesTransformer, $estimatedAvailabilitiesTransformer, $itemLocationTransformer, $returnTermsTransformer, $shipToLocationsTransformer, $shippingOptionsTransformer);
        $transformer->apply($item, $data);

        self::assertSame([$addonServicesTransformerModel], $item->getAddonServices());
        self::assertTrue($item->getEligibleForInlineCheckout());
        self::assertTrue($item->getEnabledForGuestCheckout());
        self::assertSame([$estimatedAvailabilitiesTransformerModel], $item->getEstimatedAvailabilities());
        self::assertTrue($item->getImmediatePay());
        self::assertSame($itemLocationTransformerModel, $item->getItemLocation());
        self::assertTrue($item->getPriorityListing());
        self::assertSame(108, $item->getQuantityLimitPerBuyer());
        self::assertSame($returnTermsTransformerModel, $item->getReturnTerms());
        self::assertSame([$shippingOptionsTransformerModel], $item->getShippingOptions());
        self::assertSame($shipToLocationsTransformerModel, $item->getShipToLocations());
        self::assertTrue($item->getTopRatedBuyingExperience());
    }

    public function testApplyLeavesTheItemUntouchedWhenNothingIsPresent(): void
    {
        $item = new Item('v_0');
        $transformer = new ItemFulfilmentTransformer(self::createStub(AddonServicesTransformerInterface::class), self::createStub(EstimatedAvailabilitiesTransformerInterface::class), self::createStub(ItemLocationTransformerInterface::class), self::createStub(ReturnTermsTransformerInterface::class), self::createStub(ShipToLocationsTransformerInterface::class), self::createStub(ShippingOptionsTransformerInterface::class));

        $transformer->apply($item, []);

        self::assertSame(serialize(new Item('v_0')), serialize($item));
    }
}

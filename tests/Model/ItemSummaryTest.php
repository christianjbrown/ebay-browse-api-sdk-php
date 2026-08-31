<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\CategoryInterface;
use ChristianBrown\EBay\Browse\Model\ConvertedAmountInterface;
use ChristianBrown\EBay\Browse\Model\ImageInterface;
use ChristianBrown\EBay\Browse\Model\ItemLocationInterface;
use ChristianBrown\EBay\Browse\Model\ItemSummary;
use ChristianBrown\EBay\Browse\Model\MarketingPriceInterface;
use ChristianBrown\EBay\Browse\Model\SellerInterface;
use ChristianBrown\EBay\Browse\Model\ShippingOptionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ItemSummary::class)]
final class ItemSummaryTest extends TestCase
{
    public function test(): void
    {
        $additionalImages = [self::createStub(ImageInterface::class)];
        $categories = [self::createStub(CategoryInterface::class)];
        $currentBidPrice = self::createStub(ConvertedAmountInterface::class);
        $image = self::createStub(ImageInterface::class);
        $itemLocation = self::createStub(ItemLocationInterface::class);
        $marketingPrice = self::createStub(MarketingPriceInterface::class);
        $price = self::createStub(ConvertedAmountInterface::class);
        $seller = self::createStub(SellerInterface::class);
        $shippingOptions = [self::createStub(ShippingOptionInterface::class)];
        $thumbnailImages = [self::createStub(ImageInterface::class)];
        $unitPrice = self::createStub(ConvertedAmountInterface::class);

        $itemSummary = new ItemSummary('v_0');
        self::assertSame([], $itemSummary->getAdditionalImages());
        self::assertNull($itemSummary->getAdultOnly());
        self::assertNull($itemSummary->getAvailableCoupons());
        self::assertNull($itemSummary->getBidCount());
        self::assertSame([], $itemSummary->getBuyingOptions());
        self::assertSame([], $itemSummary->getCategories());
        self::assertNull($itemSummary->getCondition());
        self::assertNull($itemSummary->getConditionId());
        self::assertNull($itemSummary->getCurrentBidPrice());
        self::assertNull($itemSummary->getEnergyEfficiencyClass());
        self::assertNull($itemSummary->getEpid());
        self::assertNull($itemSummary->getImage());
        self::assertNull($itemSummary->getItemAffiliateWebUrl());
        self::assertNull($itemSummary->getItemCreationDate());
        self::assertNull($itemSummary->getItemEndDate());
        self::assertNull($itemSummary->getItemGroupHref());
        self::assertNull($itemSummary->getItemGroupType());
        self::assertNull($itemSummary->getItemHref());
        self::assertSame('v_0', $itemSummary->getItemId());
        self::assertNull($itemSummary->getItemLocation());
        self::assertNull($itemSummary->getItemOriginDate());
        self::assertNull($itemSummary->getItemWebUrl());
        self::assertSame([], $itemSummary->getLeafCategoryIds());
        self::assertNull($itemSummary->getLegacyItemId());
        self::assertNull($itemSummary->getListingMarketplaceId());
        self::assertNull($itemSummary->getMarketingPrice());
        self::assertNull($itemSummary->getPrice());
        self::assertNull($itemSummary->getPriorityListing());
        self::assertNull($itemSummary->getSeller());
        self::assertSame([], $itemSummary->getShippingOptions());
        self::assertNull($itemSummary->getShortDescription());
        self::assertSame([], $itemSummary->getThumbnailImages());
        self::assertNull($itemSummary->getTitle());
        self::assertNull($itemSummary->getTopRatedBuyingExperience());
        self::assertNull($itemSummary->getUnitPrice());
        self::assertNull($itemSummary->getUnitPricingMeasure());
        self::assertNull($itemSummary->getWatchCount());

        self::assertSame($itemSummary, $itemSummary->setAdditionalImages($additionalImages));
        self::assertSame($itemSummary, $itemSummary->setAdultOnly(false));
        self::assertSame($itemSummary, $itemSummary->setAvailableCoupons(false));
        self::assertSame($itemSummary, $itemSummary->setBidCount(154));
        self::assertSame($itemSummary, $itemSummary->setBuyingOptions(['s_55']));
        self::assertSame($itemSummary, $itemSummary->setCategories($categories));
        self::assertSame($itemSummary, $itemSummary->setCondition('v_57'));
        self::assertSame($itemSummary, $itemSummary->setConditionId('v_58'));
        self::assertSame($itemSummary, $itemSummary->setCurrentBidPrice($currentBidPrice));
        self::assertSame($itemSummary, $itemSummary->setEnergyEfficiencyClass('v_60'));
        self::assertSame($itemSummary, $itemSummary->setEpid('v_61'));
        self::assertSame($itemSummary, $itemSummary->setImage($image));
        self::assertSame($itemSummary, $itemSummary->setItemAffiliateWebUrl('v_63'));
        self::assertSame($itemSummary, $itemSummary->setItemCreationDate(1700000064));
        self::assertSame($itemSummary, $itemSummary->setItemEndDate(1700000065));
        self::assertSame($itemSummary, $itemSummary->setItemGroupHref('v_66'));
        self::assertSame($itemSummary, $itemSummary->setItemGroupType('v_67'));
        self::assertSame($itemSummary, $itemSummary->setItemHref('v_68'));
        self::assertSame($itemSummary, $itemSummary->setItemId('v_69'));
        self::assertSame($itemSummary, $itemSummary->setItemLocation($itemLocation));
        self::assertSame($itemSummary, $itemSummary->setItemOriginDate(1700000071));
        self::assertSame($itemSummary, $itemSummary->setItemWebUrl('v_72'));
        self::assertSame($itemSummary, $itemSummary->setLeafCategoryIds(['s_73']));
        self::assertSame($itemSummary, $itemSummary->setLegacyItemId('v_74'));
        self::assertSame($itemSummary, $itemSummary->setListingMarketplaceId('v_75'));
        self::assertSame($itemSummary, $itemSummary->setMarketingPrice($marketingPrice));
        self::assertSame($itemSummary, $itemSummary->setPrice($price));
        self::assertSame($itemSummary, $itemSummary->setPriorityListing(false));
        self::assertSame($itemSummary, $itemSummary->setSeller($seller));
        self::assertSame($itemSummary, $itemSummary->setShippingOptions($shippingOptions));
        self::assertSame($itemSummary, $itemSummary->setShortDescription('v_81'));
        self::assertSame($itemSummary, $itemSummary->setThumbnailImages($thumbnailImages));
        self::assertSame($itemSummary, $itemSummary->setTitle('v_83'));
        self::assertSame($itemSummary, $itemSummary->setTopRatedBuyingExperience(false));
        self::assertSame($itemSummary, $itemSummary->setUnitPrice($unitPrice));
        self::assertSame($itemSummary, $itemSummary->setUnitPricingMeasure('v_86'));
        self::assertSame($itemSummary, $itemSummary->setWatchCount(187));

        self::assertSame($additionalImages, $itemSummary->getAdditionalImages());
        self::assertFalse($itemSummary->getAdultOnly());
        self::assertFalse($itemSummary->getAvailableCoupons());
        self::assertSame(154, $itemSummary->getBidCount());
        self::assertSame(['s_55'], $itemSummary->getBuyingOptions());
        self::assertSame($categories, $itemSummary->getCategories());
        self::assertSame('v_57', $itemSummary->getCondition());
        self::assertSame('v_58', $itemSummary->getConditionId());
        self::assertSame($currentBidPrice, $itemSummary->getCurrentBidPrice());
        self::assertSame('v_60', $itemSummary->getEnergyEfficiencyClass());
        self::assertSame('v_61', $itemSummary->getEpid());
        self::assertSame($image, $itemSummary->getImage());
        self::assertSame('v_63', $itemSummary->getItemAffiliateWebUrl());
        self::assertSame(1700000064, $itemSummary->getItemCreationDate());
        self::assertSame(1700000065, $itemSummary->getItemEndDate());
        self::assertSame('v_66', $itemSummary->getItemGroupHref());
        self::assertSame('v_67', $itemSummary->getItemGroupType());
        self::assertSame('v_68', $itemSummary->getItemHref());
        self::assertSame('v_69', $itemSummary->getItemId());
        self::assertSame($itemLocation, $itemSummary->getItemLocation());
        self::assertSame(1700000071, $itemSummary->getItemOriginDate());
        self::assertSame('v_72', $itemSummary->getItemWebUrl());
        self::assertSame(['s_73'], $itemSummary->getLeafCategoryIds());
        self::assertSame('v_74', $itemSummary->getLegacyItemId());
        self::assertSame('v_75', $itemSummary->getListingMarketplaceId());
        self::assertSame($marketingPrice, $itemSummary->getMarketingPrice());
        self::assertSame($price, $itemSummary->getPrice());
        self::assertFalse($itemSummary->getPriorityListing());
        self::assertSame($seller, $itemSummary->getSeller());
        self::assertSame($shippingOptions, $itemSummary->getShippingOptions());
        self::assertSame('v_81', $itemSummary->getShortDescription());
        self::assertSame($thumbnailImages, $itemSummary->getThumbnailImages());
        self::assertSame('v_83', $itemSummary->getTitle());
        self::assertFalse($itemSummary->getTopRatedBuyingExperience());
        self::assertSame($unitPrice, $itemSummary->getUnitPrice());
        self::assertSame('v_86', $itemSummary->getUnitPricingMeasure());
        self::assertSame(187, $itemSummary->getWatchCount());
    }
}

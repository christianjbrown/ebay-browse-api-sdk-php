<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests;

use ChristianBrown\EBay\Browse\Api\ItemApi;
use ChristianBrown\EBay\Browse\Api\ItemApiInterface;
use ChristianBrown\EBay\Browse\Api\ItemCompatibilityApi;
use ChristianBrown\EBay\Browse\Api\ItemCompatibilityApiInterface;
use ChristianBrown\EBay\Browse\Api\ItemSummaryApi;
use ChristianBrown\EBay\Browse\Api\ItemSummaryApiInterface;
use ChristianBrown\EBay\Browse\Auth\Credentials;
use ChristianBrown\EBay\Browse\Browse;
use ChristianBrown\EBay\Browse\Cache\ArrayKeyedCache;
use ChristianBrown\EBay\Browse\Container\ApiClientServiceRegistrar;
use ChristianBrown\EBay\Browse\Container\ComposedTransformerServiceRegistrar;
use ChristianBrown\EBay\Browse\Container\ContainerFactory;
use ChristianBrown\EBay\Browse\Container\CoreServiceRegistrar;
use ChristianBrown\EBay\Browse\Container\LeafTransformerServiceRegistrar;
use ChristianBrown\EBay\Browse\Enums\MarketplaceId;
use ChristianBrown\EBay\Browse\Http\ApiHost;
use ChristianBrown\EBay\Browse\Marketplace;
use ChristianBrown\EBay\Browse\Transformer\AspectDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectValueDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectValueDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\AutoCorrectionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\BuyingOptionDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\BuyingOptionDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoriesTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoryDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoryDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoryTransformer;
use ChristianBrown\EBay\Browse\Transformer\CommonDescriptionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\CommonDescriptionTransformer;
use ChristianBrown\EBay\Browse\Transformer\CompatibilityResponseTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConvertedAmountTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorParametersTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorParameterTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorTransformer;
use ChristianBrown\EBay\Browse\Transformer\EstimatedAvailabilitiesTransformer;
use ChristianBrown\EBay\Browse\Transformer\EstimatedAvailabilityTransformer;
use ChristianBrown\EBay\Browse\Transformer\ImagesTransformer;
use ChristianBrown\EBay\Browse\Transformer\ImageTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemGroupTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemLocationTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemSummariesTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemSummaryTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformer;
use ChristianBrown\EBay\Browse\Transformer\MarketingPriceTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodBrandsTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodBrandTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodsTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductTransformer;
use ChristianBrown\EBay\Browse\Transformer\RefinementTransformer;
use ChristianBrown\EBay\Browse\Transformer\ReturnTermsTransformer;
use ChristianBrown\EBay\Browse\Transformer\SearchPagedCollectionTransformer;
use ChristianBrown\EBay\Browse\Transformer\SellerTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShippingOptionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShippingOptionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToLocationsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToRegionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToRegionTransformer;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformer;
use ChristianBrown\EBay\Browse\Transformer\TimeDurationTransformer;
use ChristianBrown\EBay\Browse\Transformer\TypedNameValuesTransformer;
use ChristianBrown\EBay\Browse\Transformer\TypedNameValueTransformer;
use ChristianBrown\KeyValueStore\MemoryKeyValueStore;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Browse::class)]
#[UsesClass(ApiClientServiceRegistrar::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(ArrayKeyedCache::class)]
#[UsesClass(AspectDistributionTransformer::class)]
#[UsesClass(AspectDistributionsTransformer::class)]
#[UsesClass(AspectValueDistributionTransformer::class)]
#[UsesClass(AspectValueDistributionsTransformer::class)]
#[UsesClass(AutoCorrectionsTransformer::class)]
#[UsesClass(BuyingOptionDistributionTransformer::class)]
#[UsesClass(BuyingOptionDistributionsTransformer::class)]
#[UsesClass(CategoriesTransformer::class)]
#[UsesClass(CategoryDistributionTransformer::class)]
#[UsesClass(CategoryDistributionsTransformer::class)]
#[UsesClass(CategoryTransformer::class)]
#[UsesClass(CommonDescriptionTransformer::class)]
#[UsesClass(CommonDescriptionsTransformer::class)]
#[UsesClass(CompatibilityResponseTransformer::class)]
#[UsesClass(ComposedTransformerServiceRegistrar::class)]
#[UsesClass(ConditionDistributionTransformer::class)]
#[UsesClass(ConditionDistributionsTransformer::class)]
#[UsesClass(ContainerFactory::class)]
#[UsesClass(ConvertedAmountTransformer::class)]
#[UsesClass(CoreServiceRegistrar::class)]
#[UsesClass(Credentials::class)]
#[UsesClass(ErrorParameterTransformer::class)]
#[UsesClass(ErrorParametersTransformer::class)]
#[UsesClass(ErrorTransformer::class)]
#[UsesClass(ErrorsTransformer::class)]
#[UsesClass(EstimatedAvailabilitiesTransformer::class)]
#[UsesClass(EstimatedAvailabilityTransformer::class)]
#[UsesClass(ImageTransformer::class)]
#[UsesClass(ImagesTransformer::class)]
#[UsesClass(ItemApi::class)]
#[UsesClass(ItemCompatibilityApi::class)]
#[UsesClass(ItemGroupTransformer::class)]
#[UsesClass(ItemLocationTransformer::class)]
#[UsesClass(ItemSummariesTransformer::class)]
#[UsesClass(ItemSummaryApi::class)]
#[UsesClass(ItemSummaryTransformer::class)]
#[UsesClass(ItemTransformer::class)]
#[UsesClass(ItemsTransformer::class)]
#[UsesClass(LeafTransformerServiceRegistrar::class)]
#[UsesClass(MarketingPriceTransformer::class)]
#[UsesClass(Marketplace::class)]
#[UsesClass(PaymentMethodBrandTransformer::class)]
#[UsesClass(PaymentMethodBrandsTransformer::class)]
#[UsesClass(PaymentMethodTransformer::class)]
#[UsesClass(PaymentMethodsTransformer::class)]
#[UsesClass(ProductTransformer::class)]
#[UsesClass(RefinementTransformer::class)]
#[UsesClass(ReturnTermsTransformer::class)]
#[UsesClass(SearchPagedCollectionTransformer::class)]
#[UsesClass(SellerTransformer::class)]
#[UsesClass(ShipToLocationsTransformer::class)]
#[UsesClass(ShipToRegionTransformer::class)]
#[UsesClass(ShipToRegionsTransformer::class)]
#[UsesClass(ShippingOptionTransformer::class)]
#[UsesClass(ShippingOptionsTransformer::class)]
#[UsesClass(StringsTransformer::class)]
#[UsesClass(TimeDurationTransformer::class)]
#[UsesClass(TypedNameValueTransformer::class)]
#[UsesClass(TypedNameValuesTransformer::class)]
final class BrowseTest extends TestCase
{
    public function testItemApi(): void
    {
        self::assertInstanceOf(ItemApiInterface::class, $this->buildBrowse()->getItemApi());
    }

    public function testItemApiReturnsSharedInstance(): void
    {
        $browse = $this->buildBrowse();

        self::assertSame($browse->getItemApi(), $browse->getItemApi());
    }

    public function testItemApiWithAnExplicitApiHost(): void
    {
        $browse = new Browse('test-client-id', 'test-client-secret', new Marketplace(MarketplaceId::EBAY_GB), new MemoryKeyValueStore(), ApiHost::sandbox());

        self::assertInstanceOf(ItemApiInterface::class, $browse->getItemApi());
    }

    public function testItemCompatibilityApi(): void
    {
        self::assertInstanceOf(ItemCompatibilityApiInterface::class, $this->buildBrowse()->getItemCompatibilityApi());
    }

    public function testItemCompatibilityApiReturnsSharedInstance(): void
    {
        $browse = $this->buildBrowse();

        self::assertSame($browse->getItemCompatibilityApi(), $browse->getItemCompatibilityApi());
    }

    public function testItemSummaryApi(): void
    {
        self::assertInstanceOf(ItemSummaryApiInterface::class, $this->buildBrowse()->getItemSummaryApi());
    }

    public function testItemSummaryApiReturnsSharedInstance(): void
    {
        $browse = $this->buildBrowse();

        self::assertSame($browse->getItemSummaryApi(), $browse->getItemSummaryApi());
    }

    private function buildBrowse(): Browse
    {
        return new Browse('test-client-id', 'test-client-secret', new Marketplace(MarketplaceId::EBAY_GB), new MemoryKeyValueStore());
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests;

use ChristianBrown\EBay\Browse\Api\ItemApi;
use ChristianBrown\EBay\Browse\Api\ItemCompatibilityApi;
use ChristianBrown\EBay\Browse\Api\ItemCompatibilityApiInterface;
use ChristianBrown\EBay\Browse\Api\ItemSummaryApi;
use ChristianBrown\EBay\Browse\Api\ItemSummaryApiInterface;
use ChristianBrown\EBay\Browse\Auth\Credentials;
use ChristianBrown\EBay\Browse\Browse;
use ChristianBrown\EBay\Browse\BrowseFactory;
use ChristianBrown\EBay\Browse\BrowseInterface;
use ChristianBrown\EBay\Browse\Cache\ArrayKeyedCache;
use ChristianBrown\EBay\Browse\Container\ApiClientServiceRegistrar;
use ChristianBrown\EBay\Browse\Container\ComposedTransformerServiceRegistrar;
use ChristianBrown\EBay\Browse\Container\ContainerFactory;
use ChristianBrown\EBay\Browse\Container\CoreServiceRegistrar;
use ChristianBrown\EBay\Browse\Container\LeafTransformerServiceRegistrar;
use ChristianBrown\EBay\Browse\Enums\MarketplaceId;
use ChristianBrown\EBay\Browse\Http\ApiHost;
use ChristianBrown\EBay\Browse\Marketplace;
use ChristianBrown\EBay\Browse\Transformer\AdditionalProductIdentitiesTransformer;
use ChristianBrown\EBay\Browse\Transformer\AdditionalProductIdentityTransformer;
use ChristianBrown\EBay\Browse\Transformer\AddonServicesTransformer;
use ChristianBrown\EBay\Browse\Transformer\AddonServiceTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectGroupsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectGroupTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectValueDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectValueDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\AuthenticityGuaranteeProgramTransformer;
use ChristianBrown\EBay\Browse\Transformer\AuthenticityVerificationProgramTransformer;
use ChristianBrown\EBay\Browse\Transformer\AutoCorrectionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AvailableCouponsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AvailableCouponTransformer;
use ChristianBrown\EBay\Browse\Transformer\BuyingOptionDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\BuyingOptionDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoriesTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoryDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoryDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoryTransformer;
use ChristianBrown\EBay\Browse\Transformer\CommonDescriptionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\CommonDescriptionTransformer;
use ChristianBrown\EBay\Browse\Transformer\CompanyAddressTransformer;
use ChristianBrown\EBay\Browse\Transformer\CompatibilityPropertiesTransformer;
use ChristianBrown\EBay\Browse\Transformer\CompatibilityPropertyTransformer;
use ChristianBrown\EBay\Browse\Transformer\CompatibilityResponseTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorValuesTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorValueTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConvertedAmountTransformer;
use ChristianBrown\EBay\Browse\Transformer\CouponConstraintTransformer;
use ChristianBrown\EBay\Browse\Transformer\EconomicOperatorTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorParametersTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorParameterTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorTransformer;
use ChristianBrown\EBay\Browse\Transformer\EstimatedAvailabilitiesTransformer;
use ChristianBrown\EBay\Browse\Transformer\EstimatedAvailabilityTransformer;
use ChristianBrown\EBay\Browse\Transformer\HazardousMaterialsLabelsTransformer;
use ChristianBrown\EBay\Browse\Transformer\HazardPictogramsTransformer;
use ChristianBrown\EBay\Browse\Transformer\HazardPictogramTransformer;
use ChristianBrown\EBay\Browse\Transformer\HazardStatementsTransformer;
use ChristianBrown\EBay\Browse\Transformer\HazardStatementTransformer;
use ChristianBrown\EBay\Browse\Transformer\ImagesTransformer;
use ChristianBrown\EBay\Browse\Transformer\ImageTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemCharityTermsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemGroupSummaryTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemGroupTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemLocationTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemsResponseTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemSummariesTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemSummaryTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformer;
use ChristianBrown\EBay\Browse\Transformer\LegalAddressTransformer;
use ChristianBrown\EBay\Browse\Transformer\MarketingPriceTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodBrandsTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodBrandTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodsTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodTransformer;
use ChristianBrown\EBay\Browse\Transformer\PickupOptionSummariesTransformer;
use ChristianBrown\EBay\Browse\Transformer\PickupOptionSummaryTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductIdentitiesTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductIdentityTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelPictogramsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelPictogramTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelStatementsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelStatementTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductTransformer;
use ChristianBrown\EBay\Browse\Transformer\RatingHistogramsTransformer;
use ChristianBrown\EBay\Browse\Transformer\RatingHistogramTransformer;
use ChristianBrown\EBay\Browse\Transformer\RefinementTransformer;
use ChristianBrown\EBay\Browse\Transformer\RegionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ResponsiblePersonsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ResponsiblePersonTransformer;
use ChristianBrown\EBay\Browse\Transformer\ReturnTermsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ReviewRatingTransformer;
use ChristianBrown\EBay\Browse\Transformer\SearchPagedCollectionTransformer;
use ChristianBrown\EBay\Browse\Transformer\SellerCustomPoliciesTransformer;
use ChristianBrown\EBay\Browse\Transformer\SellerCustomPolicyTransformer;
use ChristianBrown\EBay\Browse\Transformer\SellerLegalInfoTransformer;
use ChristianBrown\EBay\Browse\Transformer\SellerTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShippingOptionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShippingOptionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToLocationsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToLocationTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToRegionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToRegionTransformer;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformer;
use ChristianBrown\EBay\Browse\Transformer\TargetLocationTransformer;
use ChristianBrown\EBay\Browse\Transformer\TaxesTransformer;
use ChristianBrown\EBay\Browse\Transformer\TaxJurisdictionTransformer;
use ChristianBrown\EBay\Browse\Transformer\TaxTransformer;
use ChristianBrown\EBay\Browse\Transformer\TimeDurationTransformer;
use ChristianBrown\EBay\Browse\Transformer\TypedNameValuesTransformer;
use ChristianBrown\EBay\Browse\Transformer\TypedNameValueTransformer;
use ChristianBrown\EBay\Browse\Transformer\VatDetailsTransformer;
use ChristianBrown\EBay\Browse\Transformer\VatDetailTransformer;
use ChristianBrown\KeyValueStore\MemoryKeyValueStore;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Clock\MockClock;

#[CoversClass(BrowseFactory::class)]
#[UsesClass(Browse::class)]
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
#[UsesClass(AdditionalProductIdentitiesTransformer::class)]
#[UsesClass(AdditionalProductIdentityTransformer::class)]
#[UsesClass(AddonServiceTransformer::class)]
#[UsesClass(AddonServicesTransformer::class)]
#[UsesClass(AspectGroupTransformer::class)]
#[UsesClass(AspectGroupsTransformer::class)]
#[UsesClass(AspectTransformer::class)]
#[UsesClass(AspectsTransformer::class)]
#[UsesClass(AuthenticityGuaranteeProgramTransformer::class)]
#[UsesClass(AuthenticityVerificationProgramTransformer::class)]
#[UsesClass(AvailableCouponTransformer::class)]
#[UsesClass(AvailableCouponsTransformer::class)]
#[UsesClass(CompanyAddressTransformer::class)]
#[UsesClass(CompatibilityPropertiesTransformer::class)]
#[UsesClass(CompatibilityPropertyTransformer::class)]
#[UsesClass(ConditionDescriptorTransformer::class)]
#[UsesClass(ConditionDescriptorValueTransformer::class)]
#[UsesClass(ConditionDescriptorValuesTransformer::class)]
#[UsesClass(ConditionDescriptorsTransformer::class)]
#[UsesClass(CouponConstraintTransformer::class)]
#[UsesClass(EconomicOperatorTransformer::class)]
#[UsesClass(HazardPictogramTransformer::class)]
#[UsesClass(HazardPictogramsTransformer::class)]
#[UsesClass(HazardStatementTransformer::class)]
#[UsesClass(HazardStatementsTransformer::class)]
#[UsesClass(HazardousMaterialsLabelsTransformer::class)]
#[UsesClass(ItemCharityTermsTransformer::class)]
#[UsesClass(ItemGroupSummaryTransformer::class)]
#[UsesClass(ItemsResponseTransformer::class)]
#[UsesClass(LegalAddressTransformer::class)]
#[UsesClass(PickupOptionSummariesTransformer::class)]
#[UsesClass(PickupOptionSummaryTransformer::class)]
#[UsesClass(ProductIdentitiesTransformer::class)]
#[UsesClass(ProductIdentityTransformer::class)]
#[UsesClass(ProductSafetyLabelPictogramTransformer::class)]
#[UsesClass(ProductSafetyLabelPictogramsTransformer::class)]
#[UsesClass(ProductSafetyLabelStatementTransformer::class)]
#[UsesClass(ProductSafetyLabelStatementsTransformer::class)]
#[UsesClass(ProductSafetyLabelsTransformer::class)]
#[UsesClass(RatingHistogramTransformer::class)]
#[UsesClass(RatingHistogramsTransformer::class)]
#[UsesClass(RegionTransformer::class)]
#[UsesClass(ResponsiblePersonTransformer::class)]
#[UsesClass(ResponsiblePersonsTransformer::class)]
#[UsesClass(ReviewRatingTransformer::class)]
#[UsesClass(SellerCustomPoliciesTransformer::class)]
#[UsesClass(SellerCustomPolicyTransformer::class)]
#[UsesClass(SellerLegalInfoTransformer::class)]
#[UsesClass(ShipToLocationTransformer::class)]
#[UsesClass(TargetLocationTransformer::class)]
#[UsesClass(TaxJurisdictionTransformer::class)]
#[UsesClass(TaxTransformer::class)]
#[UsesClass(TaxesTransformer::class)]
#[UsesClass(VatDetailTransformer::class)]
#[UsesClass(VatDetailsTransformer::class)]
final class BrowseFactoryTest extends TestCase
{
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

    public function testItemSummaryApiWithASandboxApiHost(): void
    {
        $browse = (new BrowseFactory(ApiHost::sandbox()))->create('test-client-id', 'test-client-secret', new Marketplace(MarketplaceId::EBAY_GB), new MemoryKeyValueStore(new MockClock()));

        self::assertInstanceOf(ItemSummaryApiInterface::class, $browse->getItemSummaryApi());
    }

    private function buildBrowse(): BrowseInterface
    {
        return (new BrowseFactory(ApiHost::production()))->create('test-client-id', 'test-client-secret', new Marketplace(MarketplaceId::EBAY_GB), new MemoryKeyValueStore(new MockClock()));
    }
}

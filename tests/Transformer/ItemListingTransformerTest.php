<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\AuthenticityGuaranteeProgramInterface;
use ChristianBrown\EBay\Browse\Model\AuthenticityVerificationProgramInterface;
use ChristianBrown\EBay\Browse\Model\Item;
use ChristianBrown\EBay\Browse\Model\ItemCharityTermsInterface;
use ChristianBrown\EBay\Browse\Model\SellerCustomPolicyInterface;
use ChristianBrown\EBay\Browse\Model\SellerInterface;
use ChristianBrown\EBay\Browse\Transformer\AuthenticityGuaranteeProgramTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\AuthenticityVerificationProgramTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemCharityTermsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemListingTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\SellerCustomPoliciesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\SellerTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
#[CoversClass(ItemListingTransformer::class)]
final class ItemListingTransformerTest extends TestCase
{
    public function testApply(): void
    {
        $authenticityGuaranteeProgramTransformerModel = self::createStub(AuthenticityGuaranteeProgramInterface::class);
        $authenticityGuaranteeProgramTransformer = self::createStub(AuthenticityGuaranteeProgramTransformerInterface::class);
        $authenticityGuaranteeProgramTransformer->method('transform')->willReturn($authenticityGuaranteeProgramTransformerModel);
        $authenticityVerificationProgramTransformerModel = self::createStub(AuthenticityVerificationProgramInterface::class);
        $authenticityVerificationProgramTransformer = self::createStub(AuthenticityVerificationProgramTransformerInterface::class);
        $authenticityVerificationProgramTransformer->method('transform')->willReturn($authenticityVerificationProgramTransformerModel);
        $itemCharityTermsTransformerModel = self::createStub(ItemCharityTermsInterface::class);
        $itemCharityTermsTransformer = self::createStub(ItemCharityTermsTransformerInterface::class);
        $itemCharityTermsTransformer->method('transform')->willReturn($itemCharityTermsTransformerModel);
        $stringsTransformerModel = 's';
        $stringsTransformer = self::createStub(StringsTransformerInterface::class);
        $stringsTransformer->method('transform')->willReturn([$stringsTransformerModel]);
        $sellerTransformerModel = self::createStub(SellerInterface::class);
        $sellerTransformer = self::createStub(SellerTransformerInterface::class);
        $sellerTransformer->method('transform')->willReturn($sellerTransformerModel);
        $sellerCustomPoliciesTransformerModel = self::createStub(SellerCustomPolicyInterface::class);
        $sellerCustomPoliciesTransformer = self::createStub(SellerCustomPoliciesTransformerInterface::class);
        $sellerCustomPoliciesTransformer->method('transform')->willReturn([$sellerCustomPoliciesTransformerModel]);
        $data = [
            ItemTransformerInterface::KEY_AUTHENTICITY_GUARANTEE => ['raw_AuthenticityGuarantee'],
            ItemTransformerInterface::KEY_AUTHENTICITY_VERIFICATION => ['raw_AuthenticityVerification'],
            ItemTransformerInterface::KEY_CHARITY_TERMS => ['raw_CharityTerms'],
            ItemTransformerInterface::KEY_ITEM_CREATION_DATE => '2026-01-01T00:00:00Z',
            ItemTransformerInterface::KEY_ITEM_END_DATE => '2026-01-01T00:00:00Z',
            ItemTransformerInterface::KEY_LISTING_MARKETPLACE_ID => 'v_6',
            ItemTransformerInterface::KEY_QUALIFIED_PROGRAMS => ['raw_QualifiedPrograms'],
            ItemTransformerInterface::KEY_SELLER => ['raw_Seller'],
            ItemTransformerInterface::KEY_SELLER_CUSTOM_POLICIES => ['raw_SellerCustomPolicies'],
            ItemTransformerInterface::KEY_SELLER_ITEM_REVISION => 'v_10',
            ItemTransformerInterface::KEY_WATCH_COUNT => 111,
        ];
        $item = new Item('v_0');

        $transformer = new ItemListingTransformer($authenticityGuaranteeProgramTransformer, $authenticityVerificationProgramTransformer, $itemCharityTermsTransformer, $sellerCustomPoliciesTransformer, $sellerTransformer, $stringsTransformer);
        $transformer->apply($item, $data);

        self::assertSame($authenticityGuaranteeProgramTransformerModel, $item->getAuthenticityGuarantee());
        self::assertSame($authenticityVerificationProgramTransformerModel, $item->getAuthenticityVerification());
        self::assertSame($itemCharityTermsTransformerModel, $item->getCharityTerms());
        self::assertSame(1767225600, $item->getItemCreationDate());
        self::assertSame(1767225600, $item->getItemEndDate());
        self::assertSame('v_6', $item->getListingMarketplaceId());
        self::assertSame([$stringsTransformerModel], $item->getQualifiedPrograms());
        self::assertSame($sellerTransformerModel, $item->getSeller());
        self::assertSame([$sellerCustomPoliciesTransformerModel], $item->getSellerCustomPolicies());
        self::assertSame('v_10', $item->getSellerItemRevision());
        self::assertSame(111, $item->getWatchCount());
    }

    public function testApplyLeavesTheItemUntouchedWhenNothingIsPresent(): void
    {
        $item = new Item('v_0');
        $transformer = new ItemListingTransformer(self::createStub(AuthenticityGuaranteeProgramTransformerInterface::class), self::createStub(AuthenticityVerificationProgramTransformerInterface::class), self::createStub(ItemCharityTermsTransformerInterface::class), self::createStub(SellerCustomPoliciesTransformerInterface::class), self::createStub(SellerTransformerInterface::class), self::createStub(StringsTransformerInterface::class));

        $transformer->apply($item, []);

        self::assertSame(serialize(new Item('v_0')), serialize($item));
    }
}

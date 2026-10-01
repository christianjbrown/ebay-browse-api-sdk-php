<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\AuthenticityGuaranteeProgramInterface;
use ChristianBrown\EBay\Browse\Model\AuthenticityVerificationProgramInterface;
use ChristianBrown\EBay\Browse\Model\Item;
use ChristianBrown\EBay\Browse\Model\ItemCharityTermsInterface;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
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
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
#[CoversClass(ItemListingTransformer::class)]
final class ItemListingTransformerTest extends TestCase
{
    private ?AuthenticityGuaranteeProgramInterface $authenticityGuaranteeProgram = null;
    private ?AuthenticityVerificationProgramInterface $authenticityVerificationProgram = null;
    private ?ItemCharityTermsInterface $itemCharityTerms = null;
    private ?SellerInterface $seller = null;
    private ?SellerCustomPolicyInterface $sellerCustomPolicy = null;

    public function testApply(): void
    {
        $data = [
            ItemTransformerInterface::KEY_AUTHENTICITY_GUARANTEE => ['raw_authenticityGuarantee'],
            ItemTransformerInterface::KEY_AUTHENTICITY_VERIFICATION => ['raw_authenticityVerification'],
            ItemTransformerInterface::KEY_CHARITY_TERMS => ['raw_charityTerms'],
            ItemTransformerInterface::KEY_ITEM_CREATION_DATE => '2024-01-02T03:04:05.000Z',
            ItemTransformerInterface::KEY_ITEM_END_DATE => '2024-01-02T03:04:05.000Z',
            ItemTransformerInterface::KEY_LISTING_MARKETPLACE_ID => 'v_20',
            ItemTransformerInterface::KEY_QUALIFIED_PROGRAMS => ['raw_qualifiedPrograms'],
            ItemTransformerInterface::KEY_SELLER => ['raw_seller'],
            ItemTransformerInterface::KEY_SELLER_CUSTOM_POLICIES => ['raw_sellerCustomPolicies'],
            ItemTransformerInterface::KEY_SELLER_ITEM_REVISION => 'v_29',
            ItemTransformerInterface::KEY_WATCH_COUNT => 139,
        ];

        $transformer = $this->buildTransformer();
        $actual = new Item('v_0');

        $transformer->apply($actual, $data);

        self::assertSame($this->authenticityGuaranteeProgram, $actual->getAuthenticityGuarantee());
        self::assertSame($this->authenticityVerificationProgram, $actual->getAuthenticityVerification());
        self::assertSame($this->itemCharityTerms, $actual->getCharityTerms());
        self::assertSame(1704164645, $actual->getItemCreationDate());
        self::assertSame(1704164645, $actual->getItemEndDate());
        self::assertSame('v_20', $actual->getListingMarketplaceId());
        self::assertSame(['s'], $actual->getQualifiedPrograms());
        self::assertSame($this->seller, $actual->getSeller());
        self::assertSame([$this->sellerCustomPolicy], $actual->getSellerCustomPolicies());
        self::assertSame('v_29', $actual->getSellerItemRevision());
        self::assertSame(139, $actual->getWatchCount());
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
                self::assertNull($model->getAuthenticityGuarantee());
                self::assertNull($model->getAuthenticityVerification());
                self::assertNull($model->getCharityTerms());
                self::assertNull($model->getItemCreationDate());
                self::assertNull($model->getItemEndDate());
                self::assertNull($model->getListingMarketplaceId());
                self::assertSame([], $model->getQualifiedPrograms());
                self::assertNull($model->getSeller());
                self::assertSame([], $model->getSellerCustomPolicies());
                self::assertNull($model->getSellerItemRevision());
                self::assertNull($model->getWatchCount());
            },
        ];

        yield 'authenticityGuaranteeWrongType' => [
            [...$base, ItemTransformerInterface::KEY_AUTHENTICITY_GUARANTEE => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getAuthenticityGuarantee());
            },
        ];

        yield 'authenticityVerificationWrongType' => [
            [...$base, ItemTransformerInterface::KEY_AUTHENTICITY_VERIFICATION => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getAuthenticityVerification());
            },
        ];

        yield 'charityTermsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_CHARITY_TERMS => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getCharityTerms());
            },
        ];

        yield 'itemCreationDateWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ITEM_CREATION_DATE => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getItemCreationDate());
            },
        ];

        yield 'itemCreationDateUnparseable' => [
            [...$base, ItemTransformerInterface::KEY_ITEM_CREATION_DATE => 'not-a-date'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getItemCreationDate());
            },
        ];

        yield 'itemEndDateWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ITEM_END_DATE => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getItemEndDate());
            },
        ];

        yield 'itemEndDateUnparseable' => [
            [...$base, ItemTransformerInterface::KEY_ITEM_END_DATE => 'not-a-date'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getItemEndDate());
            },
        ];

        yield 'listingMarketplaceIdWrongType' => [
            [...$base, ItemTransformerInterface::KEY_LISTING_MARKETPLACE_ID => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getListingMarketplaceId());
            },
        ];

        yield 'qualifiedProgramsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_QUALIFIED_PROGRAMS => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getQualifiedPrograms());
            },
        ];

        yield 'sellerWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SELLER => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getSeller());
            },
        ];

        yield 'sellerCustomPoliciesWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SELLER_CUSTOM_POLICIES => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getSellerCustomPolicies());
            },
        ];

        yield 'sellerItemRevisionWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SELLER_ITEM_REVISION => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getSellerItemRevision());
            },
        ];

        yield 'watchCountWrongType' => [
            [...$base, ItemTransformerInterface::KEY_WATCH_COUNT => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getWatchCount());
            },
        ];

        yield 'watchCountZero' => [
            [...$base, ItemTransformerInterface::KEY_WATCH_COUNT => 0],
            static function (ItemInterface $model): void {
                self::assertSame(0, $model->getWatchCount());
            },
        ];
    }

    private function buildTransformer(): ItemListingTransformer
    {
        $this->authenticityGuaranteeProgram = self::createStub(AuthenticityGuaranteeProgramInterface::class);
        $this->authenticityVerificationProgram = self::createStub(AuthenticityVerificationProgramInterface::class);
        $this->itemCharityTerms = self::createStub(ItemCharityTermsInterface::class);
        $this->seller = self::createStub(SellerInterface::class);
        $this->sellerCustomPolicy = self::createStub(SellerCustomPolicyInterface::class);

        $authenticityGuaranteeProgramTransformer = self::createStub(AuthenticityGuaranteeProgramTransformerInterface::class);
        $authenticityGuaranteeProgramTransformer->method('transform')->willReturn($this->authenticityGuaranteeProgram);
        $authenticityVerificationProgramTransformer = self::createStub(AuthenticityVerificationProgramTransformerInterface::class);
        $authenticityVerificationProgramTransformer->method('transform')->willReturn($this->authenticityVerificationProgram);
        $itemCharityTermsTransformer = self::createStub(ItemCharityTermsTransformerInterface::class);
        $itemCharityTermsTransformer->method('transform')->willReturn($this->itemCharityTerms);
        $sellerCustomPoliciesTransformer = self::createStub(SellerCustomPoliciesTransformerInterface::class);
        $sellerCustomPoliciesTransformer->method('transform')->willReturn([$this->sellerCustomPolicy]);
        $sellerTransformer = self::createStub(SellerTransformerInterface::class);
        $sellerTransformer->method('transform')->willReturn($this->seller);
        $stringsTransformer = self::createStub(StringsTransformerInterface::class);
        $stringsTransformer->method('transform')->willReturn(['s']);

        return new ItemListingTransformer($authenticityGuaranteeProgramTransformer, $authenticityVerificationProgramTransformer, $itemCharityTermsTransformer, $sellerCustomPoliciesTransformer, $sellerTransformer, $stringsTransformer);
    }
}

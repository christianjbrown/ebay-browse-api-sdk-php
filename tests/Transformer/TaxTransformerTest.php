<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\Tax;
use ChristianBrown\EBay\Browse\Model\TaxInterface;
use ChristianBrown\EBay\Browse\Model\TaxJurisdictionInterface;
use ChristianBrown\EBay\Browse\Transformer\TaxJurisdictionTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\TaxTransformer;
use ChristianBrown\EBay\Browse\Transformer\TaxTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Tax::class)]
#[CoversClass(TaxTransformer::class)]
final class TaxTransformerTest extends TestCase
{
    private ?TaxJurisdictionInterface $taxJurisdiction = null;

    public function testTransform(): void
    {
        $data = [
            TaxTransformerInterface::KEY_EBAY_COLLECT_AND_REMIT_TAX => true,
            TaxTransformerInterface::KEY_INCLUDED_IN_PRICE => true,
            TaxTransformerInterface::KEY_SHIPPING_AND_HANDLING_TAXED => true,
            TaxTransformerInterface::KEY_TAX_JURISDICTION => ['raw_taxJurisdiction'],
            TaxTransformerInterface::KEY_TAX_PERCENTAGE => 'v_1',
            TaxTransformerInterface::KEY_TAX_TYPE => 'v_2',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertTrue($actual->getEbayCollectAndRemitTax());
        self::assertTrue($actual->getIncludedInPrice());
        self::assertTrue($actual->getShippingAndHandlingTaxed());
        self::assertSame($this->taxJurisdiction, $actual->getTaxJurisdiction());
        self::assertSame('v_1', $actual->getTaxPercentage());
        self::assertSame('v_2', $actual->getTaxType());
    }

    /**
     * @param array<string, mixed>        $data
     * @param Closure(TaxInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(TaxInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (TaxInterface $model): void {
                self::assertNull($model->getEbayCollectAndRemitTax());
                self::assertNull($model->getIncludedInPrice());
                self::assertNull($model->getShippingAndHandlingTaxed());
                self::assertNull($model->getTaxJurisdiction());
                self::assertNull($model->getTaxPercentage());
                self::assertNull($model->getTaxType());
            },
        ];

        yield 'ebayCollectAndRemitTaxWrongType' => [
            [...$base, TaxTransformerInterface::KEY_EBAY_COLLECT_AND_REMIT_TAX => 'x'],
            static function (TaxInterface $model): void {
                self::assertNull($model->getEbayCollectAndRemitTax());
            },
        ];

        yield 'ebayCollectAndRemitTaxFalse' => [
            [...$base, TaxTransformerInterface::KEY_EBAY_COLLECT_AND_REMIT_TAX => false],
            static function (TaxInterface $model): void {
                self::assertFalse($model->getEbayCollectAndRemitTax());
            },
        ];

        yield 'includedInPriceWrongType' => [
            [...$base, TaxTransformerInterface::KEY_INCLUDED_IN_PRICE => 'x'],
            static function (TaxInterface $model): void {
                self::assertNull($model->getIncludedInPrice());
            },
        ];

        yield 'includedInPriceFalse' => [
            [...$base, TaxTransformerInterface::KEY_INCLUDED_IN_PRICE => false],
            static function (TaxInterface $model): void {
                self::assertFalse($model->getIncludedInPrice());
            },
        ];

        yield 'shippingAndHandlingTaxedWrongType' => [
            [...$base, TaxTransformerInterface::KEY_SHIPPING_AND_HANDLING_TAXED => 'x'],
            static function (TaxInterface $model): void {
                self::assertNull($model->getShippingAndHandlingTaxed());
            },
        ];

        yield 'shippingAndHandlingTaxedFalse' => [
            [...$base, TaxTransformerInterface::KEY_SHIPPING_AND_HANDLING_TAXED => false],
            static function (TaxInterface $model): void {
                self::assertFalse($model->getShippingAndHandlingTaxed());
            },
        ];

        yield 'taxJurisdictionWrongType' => [
            [...$base, TaxTransformerInterface::KEY_TAX_JURISDICTION => 'x'],
            static function (TaxInterface $model): void {
                self::assertNull($model->getTaxJurisdiction());
            },
        ];

        yield 'taxPercentageWrongType' => [
            [...$base, TaxTransformerInterface::KEY_TAX_PERCENTAGE => 42],
            static function (TaxInterface $model): void {
                self::assertNull($model->getTaxPercentage());
            },
        ];

        yield 'taxTypeWrongType' => [
            [...$base, TaxTransformerInterface::KEY_TAX_TYPE => 42],
            static function (TaxInterface $model): void {
                self::assertNull($model->getTaxType());
            },
        ];
    }

    private function buildTransformer(): TaxTransformer
    {
        $this->taxJurisdiction = self::createStub(TaxJurisdictionInterface::class);

        $taxJurisdictionTransformer = self::createStub(TaxJurisdictionTransformerInterface::class);
        $taxJurisdictionTransformer->method('transform')->willReturn($this->taxJurisdiction);

        return new TaxTransformer($taxJurisdictionTransformer);
    }
}

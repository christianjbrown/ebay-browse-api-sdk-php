<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\VatDetail;
use ChristianBrown\EBay\Browse\Model\VatDetailInterface;
use ChristianBrown\EBay\Browse\Transformer\VatDetailTransformer;
use ChristianBrown\EBay\Browse\Transformer\VatDetailTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(VatDetail::class)]
#[CoversClass(VatDetailTransformer::class)]
final class VatDetailTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            VatDetailTransformerInterface::KEY_ISSUING_COUNTRY => 'v_1',
            VatDetailTransformerInterface::KEY_VAT_ID => 'v_2',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getIssuingCountry());
        self::assertSame('v_2', $actual->getVatId());
    }

    /**
     * @param array<string, mixed>              $data
     * @param Closure(VatDetailInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(VatDetailInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (VatDetailInterface $model): void {
                self::assertNull($model->getIssuingCountry());
                self::assertNull($model->getVatId());
            },
        ];

        yield 'issuingCountryWrongType' => [
            [...$base, VatDetailTransformerInterface::KEY_ISSUING_COUNTRY => 42],
            static function (VatDetailInterface $model): void {
                self::assertNull($model->getIssuingCountry());
            },
        ];

        yield 'vatIdWrongType' => [
            [...$base, VatDetailTransformerInterface::KEY_VAT_ID => 42],
            static function (VatDetailInterface $model): void {
                self::assertNull($model->getVatId());
            },
        ];
    }

    private function buildTransformer(): VatDetailTransformer
    {

        return new VatDetailTransformer();
    }
}

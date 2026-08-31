<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ConvertedAmountInterface;
use ChristianBrown\EBay\Browse\Model\MarketingPrice;
use ChristianBrown\EBay\Browse\Model\MarketingPriceInterface;
use ChristianBrown\EBay\Browse\Transformer\ConvertedAmountTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\MarketingPriceTransformer;
use ChristianBrown\EBay\Browse\Transformer\MarketingPriceTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(MarketingPrice::class)]
#[CoversClass(MarketingPriceTransformer::class)]
final class MarketingPriceTransformerTest extends TestCase
{
    private ?ConvertedAmountInterface $convertedAmount = null;

    public function testTransform(): void
    {
        $data = [
            MarketingPriceTransformerInterface::KEY_DISCOUNT_AMOUNT => ['raw_discountAmount'],
            MarketingPriceTransformerInterface::KEY_DISCOUNT_PERCENTAGE => 'v_1',
            MarketingPriceTransformerInterface::KEY_ORIGINAL_PRICE => ['raw_originalPrice'],
            MarketingPriceTransformerInterface::KEY_PRICE_TREATMENT => 'v_3',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($this->convertedAmount, $actual->getDiscountAmount());
        self::assertSame('v_1', $actual->getDiscountPercentage());
        self::assertSame($this->convertedAmount, $actual->getOriginalPrice());
        self::assertSame('v_3', $actual->getPriceTreatment());
    }

    /**
     * @param array<string, mixed>                   $data
     * @param Closure(MarketingPriceInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(MarketingPriceInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (MarketingPriceInterface $model): void {
                self::assertNull($model->getDiscountAmount());
                self::assertNull($model->getDiscountPercentage());
                self::assertNull($model->getOriginalPrice());
                self::assertNull($model->getPriceTreatment());
            },
        ];

        yield 'discountAmountWrongType' => [
            [...$base, MarketingPriceTransformerInterface::KEY_DISCOUNT_AMOUNT => 'x'],
            static function (MarketingPriceInterface $model): void {
                self::assertNull($model->getDiscountAmount());
            },
        ];

        yield 'discountPercentageWrongType' => [
            [...$base, MarketingPriceTransformerInterface::KEY_DISCOUNT_PERCENTAGE => 42],
            static function (MarketingPriceInterface $model): void {
                self::assertNull($model->getDiscountPercentage());
            },
        ];

        yield 'originalPriceWrongType' => [
            [...$base, MarketingPriceTransformerInterface::KEY_ORIGINAL_PRICE => 'x'],
            static function (MarketingPriceInterface $model): void {
                self::assertNull($model->getOriginalPrice());
            },
        ];

        yield 'priceTreatmentWrongType' => [
            [...$base, MarketingPriceTransformerInterface::KEY_PRICE_TREATMENT => 42],
            static function (MarketingPriceInterface $model): void {
                self::assertNull($model->getPriceTreatment());
            },
        ];
    }

    private function buildTransformer(): MarketingPriceTransformer
    {
        $this->convertedAmount = self::createStub(ConvertedAmountInterface::class);

        $convertedAmountTransformer = self::createStub(ConvertedAmountTransformerInterface::class);
        $convertedAmountTransformer->method('transform')->willReturn($this->convertedAmount);

        return new MarketingPriceTransformer($convertedAmountTransformer);
    }
}

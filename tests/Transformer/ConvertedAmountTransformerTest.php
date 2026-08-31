<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ConvertedAmount;
use ChristianBrown\EBay\Browse\Model\ConvertedAmountInterface;
use ChristianBrown\EBay\Browse\Transformer\ConvertedAmountTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConvertedAmountTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ConvertedAmount::class)]
#[CoversClass(ConvertedAmountTransformer::class)]
final class ConvertedAmountTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ConvertedAmountTransformerInterface::KEY_CURRENCY => 'v_0',
            ConvertedAmountTransformerInterface::KEY_VALUE => 'v_1',
            ConvertedAmountTransformerInterface::KEY_CONVERTED_FROM_CURRENCY => 'v_2',
            ConvertedAmountTransformerInterface::KEY_CONVERTED_FROM_VALUE => 'v_3',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getCurrency());
        self::assertSame('v_1', $actual->getValue());
        self::assertSame('v_2', $actual->getConvertedFromCurrency());
        self::assertSame('v_3', $actual->getConvertedFromValue());
    }

    /**
     * @param array<string, mixed>                    $data
     * @param Closure(ConvertedAmountInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ConvertedAmountInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [ConvertedAmountTransformerInterface::KEY_CURRENCY => 'v_0', ConvertedAmountTransformerInterface::KEY_VALUE => 'v_0'];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ConvertedAmountInterface $model): void {
                self::assertNull($model->getConvertedFromCurrency());
                self::assertNull($model->getConvertedFromValue());
            },
        ];

        yield 'convertedFromCurrencyWrongType' => [
            [...$base, ConvertedAmountTransformerInterface::KEY_CONVERTED_FROM_CURRENCY => 42],
            static function (ConvertedAmountInterface $model): void {
                self::assertNull($model->getConvertedFromCurrency());
            },
        ];

        yield 'convertedFromValueWrongType' => [
            [...$base, ConvertedAmountTransformerInterface::KEY_CONVERTED_FROM_VALUE => 42],
            static function (ConvertedAmountInterface $model): void {
                self::assertNull($model->getConvertedFromValue());
            },
        ];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[ConvertedAmountTransformerInterface::KEY_CURRENCY => 42]])]
    public function testTransformThrowsOnInvalidCurrency(array $data): void
    {
        $transformer = $this->buildTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ConvertedAmountTransformerInterface::UNEXPECTED_STRING_SPRINTF, ConvertedAmountTransformerInterface::KEY_CURRENCY));

        $transformer->transform($data);
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[ConvertedAmountTransformerInterface::KEY_CURRENCY => 'v_0']])]
    #[TestWith([[ConvertedAmountTransformerInterface::KEY_CURRENCY => 'v_0', ConvertedAmountTransformerInterface::KEY_VALUE => 42]])]
    public function testTransformThrowsOnInvalidValue(array $data): void
    {
        $transformer = $this->buildTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ConvertedAmountTransformerInterface::UNEXPECTED_STRING_SPRINTF, ConvertedAmountTransformerInterface::KEY_VALUE));

        $transformer->transform($data);
    }

    private function buildTransformer(): ConvertedAmountTransformer
    {
        return new ConvertedAmountTransformer();
    }
}

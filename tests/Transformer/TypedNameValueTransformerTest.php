<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\TypedNameValue;
use ChristianBrown\EBay\Browse\Model\TypedNameValueInterface;
use ChristianBrown\EBay\Browse\Transformer\TypedNameValueTransformer;
use ChristianBrown\EBay\Browse\Transformer\TypedNameValueTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(TypedNameValue::class)]
#[CoversClass(TypedNameValueTransformer::class)]
final class TypedNameValueTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            TypedNameValueTransformerInterface::KEY_NAME => 'v_0',
            TypedNameValueTransformerInterface::KEY_VALUE => 'v_1',
            TypedNameValueTransformerInterface::KEY_TYPE => 'v_2',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getName());
        self::assertSame('v_1', $actual->getValue());
        self::assertSame('v_2', $actual->getType());
    }

    /**
     * @param array<string, mixed>                   $data
     * @param Closure(TypedNameValueInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(TypedNameValueInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [TypedNameValueTransformerInterface::KEY_NAME => 'v_0', TypedNameValueTransformerInterface::KEY_VALUE => 'v_0'];

        yield 'allOptionalAbsent' => [
            $base,
            static function (TypedNameValueInterface $model): void {
                self::assertNull($model->getType());
            },
        ];

        yield 'typeWrongType' => [
            [...$base, TypedNameValueTransformerInterface::KEY_TYPE => 42],
            static function (TypedNameValueInterface $model): void {
                self::assertNull($model->getType());
            },
        ];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[TypedNameValueTransformerInterface::KEY_NAME => 42]])]
    public function testTransformThrowsOnInvalidName(array $data): void
    {
        $transformer = $this->buildTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(TypedNameValueTransformerInterface::UNEXPECTED_STRING_SPRINTF, TypedNameValueTransformerInterface::KEY_NAME));

        $transformer->transform($data);
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[TypedNameValueTransformerInterface::KEY_NAME => 'v_0']])]
    #[TestWith([[TypedNameValueTransformerInterface::KEY_NAME => 'v_0', TypedNameValueTransformerInterface::KEY_VALUE => 42]])]
    public function testTransformThrowsOnInvalidValue(array $data): void
    {
        $transformer = $this->buildTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(TypedNameValueTransformerInterface::UNEXPECTED_STRING_SPRINTF, TypedNameValueTransformerInterface::KEY_VALUE));

        $transformer->transform($data);
    }

    private function buildTransformer(): TypedNameValueTransformer
    {
        return new TypedNameValueTransformer();
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ErrorParameter;
use ChristianBrown\EBay\Browse\Model\ErrorParameterInterface;
use ChristianBrown\EBay\Browse\Transformer\ErrorParameterTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorParameterTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ErrorParameter::class)]
#[CoversClass(ErrorParameterTransformer::class)]
final class ErrorParameterTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ErrorParameterTransformerInterface::KEY_NAME => 'v_0',
            ErrorParameterTransformerInterface::KEY_VALUE => 'v_1',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getName());
        self::assertSame('v_1', $actual->getValue());
    }

    /**
     * @param array<string, mixed>                   $data
     * @param Closure(ErrorParameterInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ErrorParameterInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ErrorParameterInterface $model): void {
                self::assertNull($model->getName());
                self::assertNull($model->getValue());
            },
        ];

        yield 'nameWrongType' => [
            [...$base, ErrorParameterTransformerInterface::KEY_NAME => 42],
            static function (ErrorParameterInterface $model): void {
                self::assertNull($model->getName());
            },
        ];

        yield 'valueWrongType' => [
            [...$base, ErrorParameterTransformerInterface::KEY_VALUE => 42],
            static function (ErrorParameterInterface $model): void {
                self::assertNull($model->getValue());
            },
        ];
    }

    private function buildTransformer(): ErrorParameterTransformer
    {
        return new ErrorParameterTransformer();
    }
}

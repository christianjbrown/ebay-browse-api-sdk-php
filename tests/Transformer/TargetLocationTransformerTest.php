<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\TargetLocation;
use ChristianBrown\EBay\Browse\Model\TargetLocationInterface;
use ChristianBrown\EBay\Browse\Transformer\TargetLocationTransformer;
use ChristianBrown\EBay\Browse\Transformer\TargetLocationTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(TargetLocation::class)]
#[CoversClass(TargetLocationTransformer::class)]
final class TargetLocationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            TargetLocationTransformerInterface::KEY_UNIT_OF_MEASURE => 'v_1',
            TargetLocationTransformerInterface::KEY_VALUE => 'v_2',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getUnitOfMeasure());
        self::assertSame('v_2', $actual->getValue());
    }

    /**
     * @param array<string, mixed>                   $data
     * @param Closure(TargetLocationInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(TargetLocationInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (TargetLocationInterface $model): void {
                self::assertNull($model->getUnitOfMeasure());
                self::assertNull($model->getValue());
            },
        ];

        yield 'unitOfMeasureWrongType' => [
            [...$base, TargetLocationTransformerInterface::KEY_UNIT_OF_MEASURE => 42],
            static function (TargetLocationInterface $model): void {
                self::assertNull($model->getUnitOfMeasure());
            },
        ];

        yield 'valueWrongType' => [
            [...$base, TargetLocationTransformerInterface::KEY_VALUE => 42],
            static function (TargetLocationInterface $model): void {
                self::assertNull($model->getValue());
            },
        ];
    }

    private function buildTransformer(): TargetLocationTransformer
    {

        return new TargetLocationTransformer();
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ConditionDescriptor;
use ChristianBrown\EBay\Browse\Model\ConditionDescriptorInterface;
use ChristianBrown\EBay\Browse\Model\ConditionDescriptorValueInterface;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorValuesTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConditionDescriptor::class)]
#[CoversClass(ConditionDescriptorTransformer::class)]
final class ConditionDescriptorTransformerTest extends TestCase
{
    private ?ConditionDescriptorValueInterface $conditionDescriptorValue = null;

    public function testTransform(): void
    {
        $data = [
            ConditionDescriptorTransformerInterface::KEY_NAME => 'v_1',
            ConditionDescriptorTransformerInterface::KEY_VALUES => ['raw_values'],
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getName());
        self::assertSame([$this->conditionDescriptorValue], $actual->getValues());
    }

    /**
     * @param array<string, mixed>                        $data
     * @param Closure(ConditionDescriptorInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ConditionDescriptorInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ConditionDescriptorInterface $model): void {
                self::assertNull($model->getName());
                self::assertSame([], $model->getValues());
            },
        ];

        yield 'nameWrongType' => [
            [...$base, ConditionDescriptorTransformerInterface::KEY_NAME => 42],
            static function (ConditionDescriptorInterface $model): void {
                self::assertNull($model->getName());
            },
        ];

        yield 'valuesWrongType' => [
            [...$base, ConditionDescriptorTransformerInterface::KEY_VALUES => 'x'],
            static function (ConditionDescriptorInterface $model): void {
                self::assertSame([], $model->getValues());
            },
        ];
    }

    private function buildTransformer(): ConditionDescriptorTransformer
    {
        $this->conditionDescriptorValue = self::createStub(ConditionDescriptorValueInterface::class);

        $conditionDescriptorValuesTransformer = self::createStub(ConditionDescriptorValuesTransformerInterface::class);
        $conditionDescriptorValuesTransformer->method('transform')->willReturn([$this->conditionDescriptorValue]);

        return new ConditionDescriptorTransformer($conditionDescriptorValuesTransformer);
    }
}

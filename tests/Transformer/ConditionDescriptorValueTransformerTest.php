<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ConditionDescriptorValue;
use ChristianBrown\EBay\Browse\Model\ConditionDescriptorValueInterface;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorValueTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorValueTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConditionDescriptorValue::class)]
#[CoversClass(ConditionDescriptorValueTransformer::class)]
final class ConditionDescriptorValueTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ConditionDescriptorValueTransformerInterface::KEY_ADDITIONAL_INFO => ['raw_additionalInfo'],
            ConditionDescriptorValueTransformerInterface::KEY_CONTENT => 'v_1',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(['s'], $actual->getAdditionalInfo());
        self::assertSame('v_1', $actual->getContent());
    }

    /**
     * @param array<string, mixed>                             $data
     * @param Closure(ConditionDescriptorValueInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ConditionDescriptorValueInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ConditionDescriptorValueInterface $model): void {
                self::assertSame([], $model->getAdditionalInfo());
                self::assertNull($model->getContent());
            },
        ];

        yield 'additionalInfoWrongType' => [
            [...$base, ConditionDescriptorValueTransformerInterface::KEY_ADDITIONAL_INFO => 'x'],
            static function (ConditionDescriptorValueInterface $model): void {
                self::assertSame([], $model->getAdditionalInfo());
            },
        ];

        yield 'contentWrongType' => [
            [...$base, ConditionDescriptorValueTransformerInterface::KEY_CONTENT => 42],
            static function (ConditionDescriptorValueInterface $model): void {
                self::assertNull($model->getContent());
            },
        ];
    }

    private function buildTransformer(): ConditionDescriptorValueTransformer
    {

        $stringsTransformer = self::createStub(StringsTransformerInterface::class);
        $stringsTransformer->method('transform')->willReturn(['s']);

        return new ConditionDescriptorValueTransformer($stringsTransformer);
    }
}

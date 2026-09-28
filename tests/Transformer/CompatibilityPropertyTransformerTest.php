<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\CompatibilityProperty;
use ChristianBrown\EBay\Browse\Model\CompatibilityPropertyInterface;
use ChristianBrown\EBay\Browse\Transformer\CompatibilityPropertyTransformer;
use ChristianBrown\EBay\Browse\Transformer\CompatibilityPropertyTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CompatibilityProperty::class)]
#[CoversClass(CompatibilityPropertyTransformer::class)]
final class CompatibilityPropertyTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            CompatibilityPropertyTransformerInterface::KEY_LOCALIZED_NAME => 'v_1',
            CompatibilityPropertyTransformerInterface::KEY_NAME => 'v_2',
            CompatibilityPropertyTransformerInterface::KEY_VALUE => 'v_3',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getLocalizedName());
        self::assertSame('v_2', $actual->getName());
        self::assertSame('v_3', $actual->getValue());
    }

    /**
     * @param array<string, mixed>                          $data
     * @param Closure(CompatibilityPropertyInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(CompatibilityPropertyInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (CompatibilityPropertyInterface $model): void {
                self::assertNull($model->getLocalizedName());
                self::assertNull($model->getName());
                self::assertNull($model->getValue());
            },
        ];

        yield 'localizedNameWrongType' => [
            [...$base, CompatibilityPropertyTransformerInterface::KEY_LOCALIZED_NAME => 42],
            static function (CompatibilityPropertyInterface $model): void {
                self::assertNull($model->getLocalizedName());
            },
        ];

        yield 'nameWrongType' => [
            [...$base, CompatibilityPropertyTransformerInterface::KEY_NAME => 42],
            static function (CompatibilityPropertyInterface $model): void {
                self::assertNull($model->getName());
            },
        ];

        yield 'valueWrongType' => [
            [...$base, CompatibilityPropertyTransformerInterface::KEY_VALUE => 42],
            static function (CompatibilityPropertyInterface $model): void {
                self::assertNull($model->getValue());
            },
        ];
    }

    private function buildTransformer(): CompatibilityPropertyTransformer
    {

        return new CompatibilityPropertyTransformer();
    }
}

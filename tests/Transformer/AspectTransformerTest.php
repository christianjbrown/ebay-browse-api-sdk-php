<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\Aspect;
use ChristianBrown\EBay\Browse\Model\AspectInterface;
use ChristianBrown\EBay\Browse\Transformer\AspectTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Aspect::class)]
#[CoversClass(AspectTransformer::class)]
final class AspectTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            AspectTransformerInterface::KEY_LOCALIZED_NAME => 'v_1',
            AspectTransformerInterface::KEY_LOCALIZED_VALUES => ['raw_localizedValues'],
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getLocalizedName());
        self::assertSame(['s'], $actual->getLocalizedValues());
    }

    /**
     * @param array<string, mixed>           $data
     * @param Closure(AspectInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(AspectInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (AspectInterface $model): void {
                self::assertNull($model->getLocalizedName());
                self::assertSame([], $model->getLocalizedValues());
            },
        ];

        yield 'localizedNameWrongType' => [
            [...$base, AspectTransformerInterface::KEY_LOCALIZED_NAME => 42],
            static function (AspectInterface $model): void {
                self::assertNull($model->getLocalizedName());
            },
        ];

        yield 'localizedValuesWrongType' => [
            [...$base, AspectTransformerInterface::KEY_LOCALIZED_VALUES => 'x'],
            static function (AspectInterface $model): void {
                self::assertSame([], $model->getLocalizedValues());
            },
        ];
    }

    private function buildTransformer(): AspectTransformer
    {

        $stringsTransformer = self::createStub(StringsTransformerInterface::class);
        $stringsTransformer->method('transform')->willReturn(['s']);

        return new AspectTransformer($stringsTransformer);
    }
}

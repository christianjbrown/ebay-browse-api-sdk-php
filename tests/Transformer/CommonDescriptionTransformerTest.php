<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\CommonDescription;
use ChristianBrown\EBay\Browse\Model\CommonDescriptionInterface;
use ChristianBrown\EBay\Browse\Transformer\CommonDescriptionTransformer;
use ChristianBrown\EBay\Browse\Transformer\CommonDescriptionTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CommonDescription::class)]
#[CoversClass(CommonDescriptionTransformer::class)]
final class CommonDescriptionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            CommonDescriptionTransformerInterface::KEY_DESCRIPTION => 'v_0',
            CommonDescriptionTransformerInterface::KEY_ITEM_IDS => ['raw_itemIds'],
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getDescription());
        self::assertSame(['s'], $actual->getItemIds());
    }

    /**
     * @param array<string, mixed>                      $data
     * @param Closure(CommonDescriptionInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(CommonDescriptionInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (CommonDescriptionInterface $model): void {
                self::assertNull($model->getDescription());
                self::assertSame([], $model->getItemIds());
            },
        ];

        yield 'descriptionWrongType' => [
            [...$base, CommonDescriptionTransformerInterface::KEY_DESCRIPTION => 42],
            static function (CommonDescriptionInterface $model): void {
                self::assertNull($model->getDescription());
            },
        ];

        yield 'itemIdsWrongType' => [
            [...$base, CommonDescriptionTransformerInterface::KEY_ITEM_IDS => 'x'],
            static function (CommonDescriptionInterface $model): void {
                self::assertSame([], $model->getItemIds());
            },
        ];
    }

    private function buildTransformer(): CommonDescriptionTransformer
    {
        $stringsTransformer = self::createStub(StringsTransformerInterface::class);
        $stringsTransformer->method('transform')->willReturn(['s']);

        return new CommonDescriptionTransformer($stringsTransformer);
    }
}

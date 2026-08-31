<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\CommonDescriptionInterface;
use ChristianBrown\EBay\Browse\Model\ErrorInterface;
use ChristianBrown\EBay\Browse\Model\ItemGroup;
use ChristianBrown\EBay\Browse\Model\ItemGroupInterface;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use ChristianBrown\EBay\Browse\Transformer\CommonDescriptionsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ErrorsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemGroupTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemGroupTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemsTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ItemGroup::class)]
#[CoversClass(ItemGroupTransformer::class)]
final class ItemGroupTransformerTest extends TestCase
{
    private ?CommonDescriptionInterface $commonDescription = null;
    private ?ErrorInterface $error = null;
    private ?ItemInterface $item = null;

    public function testTransform(): void
    {
        $data = [
            ItemGroupTransformerInterface::KEY_COMMON_DESCRIPTIONS => ['raw_commonDescriptions'],
            ItemGroupTransformerInterface::KEY_ITEMS => ['raw_items'],
            ItemGroupTransformerInterface::KEY_WARNINGS => ['raw_warnings'],
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame([$this->commonDescription], $actual->getCommonDescriptions());
        self::assertSame([$this->item], $actual->getItems());
        self::assertSame([$this->error], $actual->getWarnings());
    }

    /**
     * @param array<string, mixed>              $data
     * @param Closure(ItemGroupInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ItemGroupInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ItemGroupInterface $model): void {
                self::assertSame([], $model->getCommonDescriptions());
                self::assertSame([], $model->getItems());
                self::assertSame([], $model->getWarnings());
            },
        ];

        yield 'commonDescriptionsWrongType' => [
            [...$base, ItemGroupTransformerInterface::KEY_COMMON_DESCRIPTIONS => 'x'],
            static function (ItemGroupInterface $model): void {
                self::assertSame([], $model->getCommonDescriptions());
            },
        ];

        yield 'itemsWrongType' => [
            [...$base, ItemGroupTransformerInterface::KEY_ITEMS => 'x'],
            static function (ItemGroupInterface $model): void {
                self::assertSame([], $model->getItems());
            },
        ];

        yield 'warningsWrongType' => [
            [...$base, ItemGroupTransformerInterface::KEY_WARNINGS => 'x'],
            static function (ItemGroupInterface $model): void {
                self::assertSame([], $model->getWarnings());
            },
        ];
    }

    private function buildTransformer(): ItemGroupTransformer
    {
        $this->commonDescription = self::createStub(CommonDescriptionInterface::class);
        $this->error = self::createStub(ErrorInterface::class);
        $this->item = self::createStub(ItemInterface::class);

        $commonDescriptionsTransformer = self::createStub(CommonDescriptionsTransformerInterface::class);
        $commonDescriptionsTransformer->method('transform')->willReturn([$this->commonDescription]);
        $errorsTransformer = self::createStub(ErrorsTransformerInterface::class);
        $errorsTransformer->method('transform')->willReturn([$this->error]);
        $itemsTransformer = self::createStub(ItemsTransformerInterface::class);
        $itemsTransformer->method('transform')->willReturn([$this->item]);

        return new ItemGroupTransformer($commonDescriptionsTransformer, $errorsTransformer, $itemsTransformer);
    }
}

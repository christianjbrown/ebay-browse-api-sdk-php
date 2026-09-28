<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ErrorInterface;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use ChristianBrown\EBay\Browse\Model\ItemsResponse;
use ChristianBrown\EBay\Browse\Model\ItemsResponseInterface;
use ChristianBrown\EBay\Browse\Transformer\ErrorsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemsResponseTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemsResponseTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemsTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ItemsResponse::class)]
#[CoversClass(ItemsResponseTransformer::class)]
final class ItemsResponseTransformerTest extends TestCase
{
    private ?ErrorInterface $error = null;
    private ?ItemInterface $item = null;

    public function testTransform(): void
    {
        $data = [
            ItemsResponseTransformerInterface::KEY_ITEMS => ['raw_items'],
            ItemsResponseTransformerInterface::KEY_TOTAL => 101,
            ItemsResponseTransformerInterface::KEY_WARNINGS => ['raw_warnings'],
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame([$this->item], $actual->getItems());
        self::assertSame(101, $actual->getTotal());
        self::assertSame([$this->error], $actual->getWarnings());
    }

    /**
     * @param array<string, mixed>                  $data
     * @param Closure(ItemsResponseInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ItemsResponseInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ItemsResponseInterface $model): void {
                self::assertSame([], $model->getItems());
                self::assertNull($model->getTotal());
                self::assertSame([], $model->getWarnings());
            },
        ];

        yield 'itemsWrongType' => [
            [...$base, ItemsResponseTransformerInterface::KEY_ITEMS => 'x'],
            static function (ItemsResponseInterface $model): void {
                self::assertSame([], $model->getItems());
            },
        ];

        yield 'totalWrongType' => [
            [...$base, ItemsResponseTransformerInterface::KEY_TOTAL => 'x'],
            static function (ItemsResponseInterface $model): void {
                self::assertNull($model->getTotal());
            },
        ];

        yield 'totalZero' => [
            [...$base, ItemsResponseTransformerInterface::KEY_TOTAL => 0],
            static function (ItemsResponseInterface $model): void {
                self::assertSame(0, $model->getTotal());
            },
        ];

        yield 'warningsWrongType' => [
            [...$base, ItemsResponseTransformerInterface::KEY_WARNINGS => 'x'],
            static function (ItemsResponseInterface $model): void {
                self::assertSame([], $model->getWarnings());
            },
        ];
    }

    private function buildTransformer(): ItemsResponseTransformer
    {
        $this->item = self::createStub(ItemInterface::class);
        $this->error = self::createStub(ErrorInterface::class);

        $errorsTransformer = self::createStub(ErrorsTransformerInterface::class);
        $errorsTransformer->method('transform')->willReturn([$this->error]);
        $itemsTransformer = self::createStub(ItemsTransformerInterface::class);
        $itemsTransformer->method('transform')->willReturn([$this->item]);

        return new ItemsResponseTransformer($errorsTransformer, $itemsTransformer);
    }
}

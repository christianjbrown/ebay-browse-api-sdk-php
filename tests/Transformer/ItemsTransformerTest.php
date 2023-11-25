<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Tests\Transformer;

use ChristianBrown\eBay\FindServiceApi\Model\ItemInterface;
use ChristianBrown\eBay\FindServiceApi\Transformer\ItemsTransformer;
use ChristianBrown\eBay\FindServiceApi\Transformer\ItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(ItemsTransformer::class)]
final class ItemsTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test(): void
    {
        $item1 = $this->createMock(ItemInterface::class);
        $item2 = $this->createMock(ItemInterface::class);
        $expected = [$item1, $item2];

        $itemTransformer = $this->createMock(ItemTransformerInterface::class);
        $itemTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-data-1'], $item1],
                    [['test-data-2'], $item2],
                ]
            );

        $transformer = new ItemsTransformer($itemTransformer);
        $actual = $transformer->transform([['test-data-1'], ['test-data-2']]);

        self::assertSame($expected, $actual);
    }
}

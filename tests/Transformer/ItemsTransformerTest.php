<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ItemsTransformer::class)]
final class ItemsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(ItemInterface::class);
        $second = self::createStub(ItemInterface::class);

        $itemTransformer = self::createStub(ItemTransformerInterface::class);
        $itemTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new ItemsTransformer($itemTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $itemTransformer = self::createStub(ItemTransformerInterface::class);

        $transformer = new ItemsTransformer($itemTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(ItemInterface::class);

        $itemTransformer = self::createMock(ItemTransformerInterface::class);
        $itemTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new ItemsTransformer($itemTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $itemTransformer = self::createStub(ItemTransformerInterface::class);

        $transformer = new ItemsTransformer($itemTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ItemsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ItemsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ItemSummaryInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemSummariesTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemSummariesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemSummaryTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ItemSummariesTransformer::class)]
final class ItemSummariesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(ItemSummaryInterface::class);
        $second = self::createStub(ItemSummaryInterface::class);

        $itemSummaryTransformer = self::createStub(ItemSummaryTransformerInterface::class);
        $itemSummaryTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new ItemSummariesTransformer($itemSummaryTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $itemSummaryTransformer = self::createStub(ItemSummaryTransformerInterface::class);

        $transformer = new ItemSummariesTransformer($itemSummaryTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(ItemSummaryInterface::class);

        $itemSummaryTransformer = self::createMock(ItemSummaryTransformerInterface::class);
        $itemSummaryTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new ItemSummariesTransformer($itemSummaryTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $itemSummaryTransformer = self::createStub(ItemSummaryTransformerInterface::class);

        $transformer = new ItemSummariesTransformer($itemSummaryTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ItemSummariesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ItemSummariesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\PickupOptionSummaryInterface;
use ChristianBrown\EBay\Browse\Transformer\PickupOptionSummariesTransformer;
use ChristianBrown\EBay\Browse\Transformer\PickupOptionSummariesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\PickupOptionSummaryTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(PickupOptionSummariesTransformer::class)]
final class PickupOptionSummariesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(PickupOptionSummaryInterface::class);
        $second = self::createStub(PickupOptionSummaryInterface::class);

        $pickupOptionSummaryTransformer = self::createStub(PickupOptionSummaryTransformerInterface::class);
        $pickupOptionSummaryTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new PickupOptionSummariesTransformer($pickupOptionSummaryTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $pickupOptionSummaryTransformer = self::createStub(PickupOptionSummaryTransformerInterface::class);

        $transformer = new PickupOptionSummariesTransformer($pickupOptionSummaryTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(PickupOptionSummaryInterface::class);

        $pickupOptionSummaryTransformer = self::createMock(PickupOptionSummaryTransformerInterface::class);
        $pickupOptionSummaryTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new PickupOptionSummariesTransformer($pickupOptionSummaryTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $pickupOptionSummaryTransformer = self::createStub(PickupOptionSummaryTransformerInterface::class);

        $transformer = new PickupOptionSummariesTransformer($pickupOptionSummaryTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(PickupOptionSummariesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, PickupOptionSummariesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

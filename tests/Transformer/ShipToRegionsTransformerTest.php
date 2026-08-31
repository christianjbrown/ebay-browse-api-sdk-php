<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ShipToRegionInterface;
use ChristianBrown\EBay\Browse\Transformer\ShipToRegionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToRegionsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ShipToRegionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ShipToRegionsTransformer::class)]
final class ShipToRegionsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(ShipToRegionInterface::class);
        $second = self::createStub(ShipToRegionInterface::class);

        $shipToRegionTransformer = self::createStub(ShipToRegionTransformerInterface::class);
        $shipToRegionTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new ShipToRegionsTransformer($shipToRegionTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $shipToRegionTransformer = self::createStub(ShipToRegionTransformerInterface::class);

        $transformer = new ShipToRegionsTransformer($shipToRegionTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(ShipToRegionInterface::class);

        $shipToRegionTransformer = self::createMock(ShipToRegionTransformerInterface::class);
        $shipToRegionTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new ShipToRegionsTransformer($shipToRegionTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $shipToRegionTransformer = self::createStub(ShipToRegionTransformerInterface::class);

        $transformer = new ShipToRegionsTransformer($shipToRegionTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ShipToRegionsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ShipToRegionsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

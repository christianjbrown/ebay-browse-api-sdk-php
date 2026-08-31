<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ShippingOptionInterface;
use ChristianBrown\EBay\Browse\Transformer\ShippingOptionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShippingOptionsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ShippingOptionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ShippingOptionsTransformer::class)]
final class ShippingOptionsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(ShippingOptionInterface::class);
        $second = self::createStub(ShippingOptionInterface::class);

        $shippingOptionTransformer = self::createStub(ShippingOptionTransformerInterface::class);
        $shippingOptionTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new ShippingOptionsTransformer($shippingOptionTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $shippingOptionTransformer = self::createStub(ShippingOptionTransformerInterface::class);

        $transformer = new ShippingOptionsTransformer($shippingOptionTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(ShippingOptionInterface::class);

        $shippingOptionTransformer = self::createMock(ShippingOptionTransformerInterface::class);
        $shippingOptionTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new ShippingOptionsTransformer($shippingOptionTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $shippingOptionTransformer = self::createStub(ShippingOptionTransformerInterface::class);

        $transformer = new ShippingOptionsTransformer($shippingOptionTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ShippingOptionsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ShippingOptionsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

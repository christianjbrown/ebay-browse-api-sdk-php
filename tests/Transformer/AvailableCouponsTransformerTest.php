<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\AvailableCouponInterface;
use ChristianBrown\EBay\Browse\Transformer\AvailableCouponsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AvailableCouponsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\AvailableCouponTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(AvailableCouponsTransformer::class)]
final class AvailableCouponsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(AvailableCouponInterface::class);
        $second = self::createStub(AvailableCouponInterface::class);

        $availableCouponTransformer = self::createStub(AvailableCouponTransformerInterface::class);
        $availableCouponTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new AvailableCouponsTransformer($availableCouponTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $availableCouponTransformer = self::createStub(AvailableCouponTransformerInterface::class);

        $transformer = new AvailableCouponsTransformer($availableCouponTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(AvailableCouponInterface::class);

        $availableCouponTransformer = self::createMock(AvailableCouponTransformerInterface::class);
        $availableCouponTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new AvailableCouponsTransformer($availableCouponTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $availableCouponTransformer = self::createStub(AvailableCouponTransformerInterface::class);

        $transformer = new AvailableCouponsTransformer($availableCouponTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(AvailableCouponsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, AvailableCouponsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

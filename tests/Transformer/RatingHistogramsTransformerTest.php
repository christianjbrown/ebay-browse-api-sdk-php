<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\RatingHistogramInterface;
use ChristianBrown\EBay\Browse\Transformer\RatingHistogramsTransformer;
use ChristianBrown\EBay\Browse\Transformer\RatingHistogramsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\RatingHistogramTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(RatingHistogramsTransformer::class)]
final class RatingHistogramsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(RatingHistogramInterface::class);
        $second = self::createStub(RatingHistogramInterface::class);

        $ratingHistogramTransformer = self::createStub(RatingHistogramTransformerInterface::class);
        $ratingHistogramTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new RatingHistogramsTransformer($ratingHistogramTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $ratingHistogramTransformer = self::createStub(RatingHistogramTransformerInterface::class);

        $transformer = new RatingHistogramsTransformer($ratingHistogramTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(RatingHistogramInterface::class);

        $ratingHistogramTransformer = self::createMock(RatingHistogramTransformerInterface::class);
        $ratingHistogramTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new RatingHistogramsTransformer($ratingHistogramTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $ratingHistogramTransformer = self::createStub(RatingHistogramTransformerInterface::class);

        $transformer = new RatingHistogramsTransformer($ratingHistogramTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(RatingHistogramsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, RatingHistogramsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ImageInterface;
use ChristianBrown\EBay\Browse\Transformer\ImagesTransformer;
use ChristianBrown\EBay\Browse\Transformer\ImagesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ImageTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ImagesTransformer::class)]
final class ImagesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(ImageInterface::class);
        $second = self::createStub(ImageInterface::class);

        $imageTransformer = self::createStub(ImageTransformerInterface::class);
        $imageTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new ImagesTransformer($imageTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $imageTransformer = self::createStub(ImageTransformerInterface::class);

        $transformer = new ImagesTransformer($imageTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(ImageInterface::class);

        $imageTransformer = self::createMock(ImageTransformerInterface::class);
        $imageTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new ImagesTransformer($imageTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $imageTransformer = self::createStub(ImageTransformerInterface::class);

        $transformer = new ImagesTransformer($imageTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ImagesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ImagesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

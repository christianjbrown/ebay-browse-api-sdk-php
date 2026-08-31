<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ErrorInterface;
use ChristianBrown\EBay\Browse\Transformer\ErrorsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ErrorTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ErrorsTransformer::class)]
final class ErrorsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(ErrorInterface::class);
        $second = self::createStub(ErrorInterface::class);

        $errorTransformer = self::createStub(ErrorTransformerInterface::class);
        $errorTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new ErrorsTransformer($errorTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $errorTransformer = self::createStub(ErrorTransformerInterface::class);

        $transformer = new ErrorsTransformer($errorTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(ErrorInterface::class);

        $errorTransformer = self::createMock(ErrorTransformerInterface::class);
        $errorTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new ErrorsTransformer($errorTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $errorTransformer = self::createStub(ErrorTransformerInterface::class);

        $transformer = new ErrorsTransformer($errorTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ErrorsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ErrorsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

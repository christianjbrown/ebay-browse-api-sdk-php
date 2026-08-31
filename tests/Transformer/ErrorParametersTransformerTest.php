<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ErrorParameterInterface;
use ChristianBrown\EBay\Browse\Transformer\ErrorParametersTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorParametersTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ErrorParameterTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ErrorParametersTransformer::class)]
final class ErrorParametersTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(ErrorParameterInterface::class);
        $second = self::createStub(ErrorParameterInterface::class);

        $errorParameterTransformer = self::createStub(ErrorParameterTransformerInterface::class);
        $errorParameterTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new ErrorParametersTransformer($errorParameterTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $errorParameterTransformer = self::createStub(ErrorParameterTransformerInterface::class);

        $transformer = new ErrorParametersTransformer($errorParameterTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(ErrorParameterInterface::class);

        $errorParameterTransformer = self::createMock(ErrorParameterTransformerInterface::class);
        $errorParameterTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new ErrorParametersTransformer($errorParameterTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $errorParameterTransformer = self::createStub(ErrorParameterTransformerInterface::class);

        $transformer = new ErrorParametersTransformer($errorParameterTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ErrorParametersTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ErrorParametersTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

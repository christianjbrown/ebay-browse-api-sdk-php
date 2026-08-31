<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\TypedNameValueInterface;
use ChristianBrown\EBay\Browse\Transformer\TypedNameValuesTransformer;
use ChristianBrown\EBay\Browse\Transformer\TypedNameValuesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\TypedNameValueTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(TypedNameValuesTransformer::class)]
final class TypedNameValuesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(TypedNameValueInterface::class);
        $second = self::createStub(TypedNameValueInterface::class);

        $typedNameValueTransformer = self::createStub(TypedNameValueTransformerInterface::class);
        $typedNameValueTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new TypedNameValuesTransformer($typedNameValueTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $typedNameValueTransformer = self::createStub(TypedNameValueTransformerInterface::class);

        $transformer = new TypedNameValuesTransformer($typedNameValueTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(TypedNameValueInterface::class);

        $typedNameValueTransformer = self::createMock(TypedNameValueTransformerInterface::class);
        $typedNameValueTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new TypedNameValuesTransformer($typedNameValueTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $typedNameValueTransformer = self::createStub(TypedNameValueTransformerInterface::class);

        $transformer = new TypedNameValuesTransformer($typedNameValueTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(TypedNameValuesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, TypedNameValuesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

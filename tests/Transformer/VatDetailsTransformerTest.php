<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\VatDetailInterface;
use ChristianBrown\EBay\Browse\Transformer\VatDetailsTransformer;
use ChristianBrown\EBay\Browse\Transformer\VatDetailsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\VatDetailTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(VatDetailsTransformer::class)]
final class VatDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(VatDetailInterface::class);
        $second = self::createStub(VatDetailInterface::class);

        $vatDetailTransformer = self::createStub(VatDetailTransformerInterface::class);
        $vatDetailTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new VatDetailsTransformer($vatDetailTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $vatDetailTransformer = self::createStub(VatDetailTransformerInterface::class);

        $transformer = new VatDetailsTransformer($vatDetailTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(VatDetailInterface::class);

        $vatDetailTransformer = self::createMock(VatDetailTransformerInterface::class);
        $vatDetailTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new VatDetailsTransformer($vatDetailTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $vatDetailTransformer = self::createStub(VatDetailTransformerInterface::class);

        $transformer = new VatDetailsTransformer($vatDetailTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(VatDetailsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, VatDetailsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

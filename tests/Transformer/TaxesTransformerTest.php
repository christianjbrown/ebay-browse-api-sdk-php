<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\TaxInterface;
use ChristianBrown\EBay\Browse\Transformer\TaxesTransformer;
use ChristianBrown\EBay\Browse\Transformer\TaxesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\TaxTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(TaxesTransformer::class)]
final class TaxesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(TaxInterface::class);
        $second = self::createStub(TaxInterface::class);

        $taxTransformer = self::createStub(TaxTransformerInterface::class);
        $taxTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new TaxesTransformer($taxTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $taxTransformer = self::createStub(TaxTransformerInterface::class);

        $transformer = new TaxesTransformer($taxTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(TaxInterface::class);

        $taxTransformer = self::createMock(TaxTransformerInterface::class);
        $taxTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new TaxesTransformer($taxTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $taxTransformer = self::createStub(TaxTransformerInterface::class);

        $transformer = new TaxesTransformer($taxTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(TaxesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, TaxesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

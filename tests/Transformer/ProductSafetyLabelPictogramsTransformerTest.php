<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelPictogramInterface;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelPictogramsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelPictogramsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelPictogramTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ProductSafetyLabelPictogramsTransformer::class)]
final class ProductSafetyLabelPictogramsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(ProductSafetyLabelPictogramInterface::class);
        $second = self::createStub(ProductSafetyLabelPictogramInterface::class);

        $productSafetyLabelPictogramTransformer = self::createStub(ProductSafetyLabelPictogramTransformerInterface::class);
        $productSafetyLabelPictogramTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new ProductSafetyLabelPictogramsTransformer($productSafetyLabelPictogramTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $productSafetyLabelPictogramTransformer = self::createStub(ProductSafetyLabelPictogramTransformerInterface::class);

        $transformer = new ProductSafetyLabelPictogramsTransformer($productSafetyLabelPictogramTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(ProductSafetyLabelPictogramInterface::class);

        $productSafetyLabelPictogramTransformer = self::createMock(ProductSafetyLabelPictogramTransformerInterface::class);
        $productSafetyLabelPictogramTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new ProductSafetyLabelPictogramsTransformer($productSafetyLabelPictogramTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $productSafetyLabelPictogramTransformer = self::createStub(ProductSafetyLabelPictogramTransformerInterface::class);

        $transformer = new ProductSafetyLabelPictogramsTransformer($productSafetyLabelPictogramTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ProductSafetyLabelPictogramsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ProductSafetyLabelPictogramsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

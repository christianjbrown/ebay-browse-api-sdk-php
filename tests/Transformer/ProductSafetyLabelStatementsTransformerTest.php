<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelStatementInterface;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelStatementsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelStatementsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelStatementTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ProductSafetyLabelStatementsTransformer::class)]
final class ProductSafetyLabelStatementsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(ProductSafetyLabelStatementInterface::class);
        $second = self::createStub(ProductSafetyLabelStatementInterface::class);

        $productSafetyLabelStatementTransformer = self::createStub(ProductSafetyLabelStatementTransformerInterface::class);
        $productSafetyLabelStatementTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new ProductSafetyLabelStatementsTransformer($productSafetyLabelStatementTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $productSafetyLabelStatementTransformer = self::createStub(ProductSafetyLabelStatementTransformerInterface::class);

        $transformer = new ProductSafetyLabelStatementsTransformer($productSafetyLabelStatementTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(ProductSafetyLabelStatementInterface::class);

        $productSafetyLabelStatementTransformer = self::createMock(ProductSafetyLabelStatementTransformerInterface::class);
        $productSafetyLabelStatementTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new ProductSafetyLabelStatementsTransformer($productSafetyLabelStatementTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $productSafetyLabelStatementTransformer = self::createStub(ProductSafetyLabelStatementTransformerInterface::class);

        $transformer = new ProductSafetyLabelStatementsTransformer($productSafetyLabelStatementTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ProductSafetyLabelStatementsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ProductSafetyLabelStatementsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

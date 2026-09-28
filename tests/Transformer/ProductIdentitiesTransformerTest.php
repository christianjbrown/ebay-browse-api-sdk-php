<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ProductIdentityInterface;
use ChristianBrown\EBay\Browse\Transformer\ProductIdentitiesTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductIdentitiesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ProductIdentityTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ProductIdentitiesTransformer::class)]
final class ProductIdentitiesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(ProductIdentityInterface::class);
        $second = self::createStub(ProductIdentityInterface::class);

        $productIdentityTransformer = self::createStub(ProductIdentityTransformerInterface::class);
        $productIdentityTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new ProductIdentitiesTransformer($productIdentityTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $productIdentityTransformer = self::createStub(ProductIdentityTransformerInterface::class);

        $transformer = new ProductIdentitiesTransformer($productIdentityTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(ProductIdentityInterface::class);

        $productIdentityTransformer = self::createMock(ProductIdentityTransformerInterface::class);
        $productIdentityTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new ProductIdentitiesTransformer($productIdentityTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $productIdentityTransformer = self::createStub(ProductIdentityTransformerInterface::class);

        $transformer = new ProductIdentitiesTransformer($productIdentityTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ProductIdentitiesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ProductIdentitiesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\CategoryDistributionInterface;
use ChristianBrown\EBay\Browse\Transformer\CategoryDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoryDistributionsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\CategoryDistributionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(CategoryDistributionsTransformer::class)]
final class CategoryDistributionsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(CategoryDistributionInterface::class);
        $second = self::createStub(CategoryDistributionInterface::class);

        $categoryDistributionTransformer = self::createStub(CategoryDistributionTransformerInterface::class);
        $categoryDistributionTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new CategoryDistributionsTransformer($categoryDistributionTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $categoryDistributionTransformer = self::createStub(CategoryDistributionTransformerInterface::class);

        $transformer = new CategoryDistributionsTransformer($categoryDistributionTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(CategoryDistributionInterface::class);

        $categoryDistributionTransformer = self::createMock(CategoryDistributionTransformerInterface::class);
        $categoryDistributionTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new CategoryDistributionsTransformer($categoryDistributionTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $categoryDistributionTransformer = self::createStub(CategoryDistributionTransformerInterface::class);

        $transformer = new CategoryDistributionsTransformer($categoryDistributionTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CategoryDistributionsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, CategoryDistributionsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

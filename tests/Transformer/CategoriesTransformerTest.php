<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\CategoryInterface;
use ChristianBrown\EBay\Browse\Transformer\CategoriesTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoriesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\CategoryTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(CategoriesTransformer::class)]
final class CategoriesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(CategoryInterface::class);
        $second = self::createStub(CategoryInterface::class);

        $categoryTransformer = self::createStub(CategoryTransformerInterface::class);
        $categoryTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new CategoriesTransformer($categoryTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $categoryTransformer = self::createStub(CategoryTransformerInterface::class);

        $transformer = new CategoriesTransformer($categoryTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(CategoryInterface::class);

        $categoryTransformer = self::createMock(CategoryTransformerInterface::class);
        $categoryTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new CategoriesTransformer($categoryTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $categoryTransformer = self::createStub(CategoryTransformerInterface::class);

        $transformer = new CategoriesTransformer($categoryTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CategoriesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, CategoriesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

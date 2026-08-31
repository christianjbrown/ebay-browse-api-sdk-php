<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\Category;
use ChristianBrown\EBay\Browse\Model\CategoryInterface;
use ChristianBrown\EBay\Browse\Transformer\CategoryTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoryTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Category::class)]
#[CoversClass(CategoryTransformer::class)]
final class CategoryTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            CategoryTransformerInterface::KEY_CATEGORY_ID => 'v_0',
            CategoryTransformerInterface::KEY_CATEGORY_NAME => 'v_1',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getCategoryId());
        self::assertSame('v_1', $actual->getCategoryName());
    }

    /**
     * @param array<string, mixed>             $data
     * @param Closure(CategoryInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(CategoryInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [CategoryTransformerInterface::KEY_CATEGORY_ID => 'v_0'];

        yield 'allOptionalAbsent' => [
            $base,
            static function (CategoryInterface $model): void {
                self::assertNull($model->getCategoryName());
            },
        ];

        yield 'categoryNameWrongType' => [
            [...$base, CategoryTransformerInterface::KEY_CATEGORY_NAME => 42],
            static function (CategoryInterface $model): void {
                self::assertNull($model->getCategoryName());
            },
        ];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[CategoryTransformerInterface::KEY_CATEGORY_ID => 42]])]
    public function testTransformThrowsOnInvalidCategoryId(array $data): void
    {
        $transformer = $this->buildTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CategoryTransformerInterface::UNEXPECTED_STRING_SPRINTF, CategoryTransformerInterface::KEY_CATEGORY_ID));

        $transformer->transform($data);
    }

    private function buildTransformer(): CategoryTransformer
    {
        return new CategoryTransformer();
    }
}

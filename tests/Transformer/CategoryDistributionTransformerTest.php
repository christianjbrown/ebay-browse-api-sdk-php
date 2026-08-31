<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\CategoryDistribution;
use ChristianBrown\EBay\Browse\Model\CategoryDistributionInterface;
use ChristianBrown\EBay\Browse\Transformer\CategoryDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoryDistributionTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CategoryDistribution::class)]
#[CoversClass(CategoryDistributionTransformer::class)]
final class CategoryDistributionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            CategoryDistributionTransformerInterface::KEY_CATEGORY_ID => 'v_0',
            CategoryDistributionTransformerInterface::KEY_CATEGORY_NAME => 'v_1',
            CategoryDistributionTransformerInterface::KEY_MATCH_COUNT => 102,
            CategoryDistributionTransformerInterface::KEY_REFINEMENT_HREF => 'v_3',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getCategoryId());
        self::assertSame('v_1', $actual->getCategoryName());
        self::assertSame(102, $actual->getMatchCount());
        self::assertSame('v_3', $actual->getRefinementHref());
    }

    /**
     * @param array<string, mixed>                         $data
     * @param Closure(CategoryDistributionInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(CategoryDistributionInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (CategoryDistributionInterface $model): void {
                self::assertNull($model->getCategoryId());
                self::assertNull($model->getCategoryName());
                self::assertNull($model->getMatchCount());
                self::assertNull($model->getRefinementHref());
            },
        ];

        yield 'categoryIdWrongType' => [
            [...$base, CategoryDistributionTransformerInterface::KEY_CATEGORY_ID => 42],
            static function (CategoryDistributionInterface $model): void {
                self::assertNull($model->getCategoryId());
            },
        ];

        yield 'categoryNameWrongType' => [
            [...$base, CategoryDistributionTransformerInterface::KEY_CATEGORY_NAME => 42],
            static function (CategoryDistributionInterface $model): void {
                self::assertNull($model->getCategoryName());
            },
        ];

        yield 'matchCountWrongType' => [
            [...$base, CategoryDistributionTransformerInterface::KEY_MATCH_COUNT => 'x'],
            static function (CategoryDistributionInterface $model): void {
                self::assertNull($model->getMatchCount());
            },
        ];

        yield 'matchCountZero' => [
            [...$base, CategoryDistributionTransformerInterface::KEY_MATCH_COUNT => 0],
            static function (CategoryDistributionInterface $model): void {
                self::assertSame(0, $model->getMatchCount());
            },
        ];

        yield 'refinementHrefWrongType' => [
            [...$base, CategoryDistributionTransformerInterface::KEY_REFINEMENT_HREF => 42],
            static function (CategoryDistributionInterface $model): void {
                self::assertNull($model->getRefinementHref());
            },
        ];
    }

    private function buildTransformer(): CategoryDistributionTransformer
    {
        return new CategoryDistributionTransformer();
    }
}

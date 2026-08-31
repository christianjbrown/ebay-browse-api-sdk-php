<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\AspectDistributionInterface;
use ChristianBrown\EBay\Browse\Model\BuyingOptionDistributionInterface;
use ChristianBrown\EBay\Browse\Model\CategoryDistributionInterface;
use ChristianBrown\EBay\Browse\Model\ConditionDistributionInterface;
use ChristianBrown\EBay\Browse\Model\Refinement;
use ChristianBrown\EBay\Browse\Model\RefinementInterface;
use ChristianBrown\EBay\Browse\Transformer\AspectDistributionsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\BuyingOptionDistributionsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\CategoryDistributionsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ConditionDistributionsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\RefinementTransformer;
use ChristianBrown\EBay\Browse\Transformer\RefinementTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Refinement::class)]
#[CoversClass(RefinementTransformer::class)]
final class RefinementTransformerTest extends TestCase
{
    private ?AspectDistributionInterface $aspectDistribution = null;
    private ?BuyingOptionDistributionInterface $buyingOptionDistribution = null;
    private ?CategoryDistributionInterface $categoryDistribution = null;
    private ?ConditionDistributionInterface $conditionDistribution = null;

    public function testTransform(): void
    {
        $data = [
            RefinementTransformerInterface::KEY_ASPECT_DISTRIBUTIONS => ['raw_aspectDistributions'],
            RefinementTransformerInterface::KEY_BUYING_OPTION_DISTRIBUTIONS => ['raw_buyingOptionDistributions'],
            RefinementTransformerInterface::KEY_CATEGORY_DISTRIBUTIONS => ['raw_categoryDistributions'],
            RefinementTransformerInterface::KEY_CONDITION_DISTRIBUTIONS => ['raw_conditionDistributions'],
            RefinementTransformerInterface::KEY_DOMINANT_CATEGORY_ID => 'v_4',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame([$this->aspectDistribution], $actual->getAspectDistributions());
        self::assertSame([$this->buyingOptionDistribution], $actual->getBuyingOptionDistributions());
        self::assertSame([$this->categoryDistribution], $actual->getCategoryDistributions());
        self::assertSame([$this->conditionDistribution], $actual->getConditionDistributions());
        self::assertSame('v_4', $actual->getDominantCategoryId());
    }

    /**
     * @param array<string, mixed>               $data
     * @param Closure(RefinementInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(RefinementInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (RefinementInterface $model): void {
                self::assertSame([], $model->getAspectDistributions());
                self::assertSame([], $model->getBuyingOptionDistributions());
                self::assertSame([], $model->getCategoryDistributions());
                self::assertSame([], $model->getConditionDistributions());
                self::assertNull($model->getDominantCategoryId());
            },
        ];

        yield 'aspectDistributionsWrongType' => [
            [...$base, RefinementTransformerInterface::KEY_ASPECT_DISTRIBUTIONS => 'x'],
            static function (RefinementInterface $model): void {
                self::assertSame([], $model->getAspectDistributions());
            },
        ];

        yield 'buyingOptionDistributionsWrongType' => [
            [...$base, RefinementTransformerInterface::KEY_BUYING_OPTION_DISTRIBUTIONS => 'x'],
            static function (RefinementInterface $model): void {
                self::assertSame([], $model->getBuyingOptionDistributions());
            },
        ];

        yield 'categoryDistributionsWrongType' => [
            [...$base, RefinementTransformerInterface::KEY_CATEGORY_DISTRIBUTIONS => 'x'],
            static function (RefinementInterface $model): void {
                self::assertSame([], $model->getCategoryDistributions());
            },
        ];

        yield 'conditionDistributionsWrongType' => [
            [...$base, RefinementTransformerInterface::KEY_CONDITION_DISTRIBUTIONS => 'x'],
            static function (RefinementInterface $model): void {
                self::assertSame([], $model->getConditionDistributions());
            },
        ];

        yield 'dominantCategoryIdWrongType' => [
            [...$base, RefinementTransformerInterface::KEY_DOMINANT_CATEGORY_ID => 42],
            static function (RefinementInterface $model): void {
                self::assertNull($model->getDominantCategoryId());
            },
        ];
    }

    private function buildTransformer(): RefinementTransformer
    {
        $this->aspectDistribution = self::createStub(AspectDistributionInterface::class);
        $this->buyingOptionDistribution = self::createStub(BuyingOptionDistributionInterface::class);
        $this->categoryDistribution = self::createStub(CategoryDistributionInterface::class);
        $this->conditionDistribution = self::createStub(ConditionDistributionInterface::class);

        $aspectDistributionsTransformer = self::createStub(AspectDistributionsTransformerInterface::class);
        $aspectDistributionsTransformer->method('transform')->willReturn([$this->aspectDistribution]);
        $buyingOptionDistributionsTransformer = self::createStub(BuyingOptionDistributionsTransformerInterface::class);
        $buyingOptionDistributionsTransformer->method('transform')->willReturn([$this->buyingOptionDistribution]);
        $categoryDistributionsTransformer = self::createStub(CategoryDistributionsTransformerInterface::class);
        $categoryDistributionsTransformer->method('transform')->willReturn([$this->categoryDistribution]);
        $conditionDistributionsTransformer = self::createStub(ConditionDistributionsTransformerInterface::class);
        $conditionDistributionsTransformer->method('transform')->willReturn([$this->conditionDistribution]);

        return new RefinementTransformer($aspectDistributionsTransformer, $buyingOptionDistributionsTransformer, $categoryDistributionsTransformer, $conditionDistributionsTransformer);
    }
}

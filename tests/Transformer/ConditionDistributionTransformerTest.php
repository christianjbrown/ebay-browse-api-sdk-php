<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ConditionDistribution;
use ChristianBrown\EBay\Browse\Model\ConditionDistributionInterface;
use ChristianBrown\EBay\Browse\Transformer\ConditionDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDistributionTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConditionDistribution::class)]
#[CoversClass(ConditionDistributionTransformer::class)]
final class ConditionDistributionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ConditionDistributionTransformerInterface::KEY_CONDITION => 'v_0',
            ConditionDistributionTransformerInterface::KEY_CONDITION_ID => 'v_1',
            ConditionDistributionTransformerInterface::KEY_MATCH_COUNT => 102,
            ConditionDistributionTransformerInterface::KEY_REFINEMENT_HREF => 'v_3',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getCondition());
        self::assertSame('v_1', $actual->getConditionId());
        self::assertSame(102, $actual->getMatchCount());
        self::assertSame('v_3', $actual->getRefinementHref());
    }

    /**
     * @param array<string, mixed>                          $data
     * @param Closure(ConditionDistributionInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ConditionDistributionInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ConditionDistributionInterface $model): void {
                self::assertNull($model->getCondition());
                self::assertNull($model->getConditionId());
                self::assertNull($model->getMatchCount());
                self::assertNull($model->getRefinementHref());
            },
        ];

        yield 'conditionWrongType' => [
            [...$base, ConditionDistributionTransformerInterface::KEY_CONDITION => 42],
            static function (ConditionDistributionInterface $model): void {
                self::assertNull($model->getCondition());
            },
        ];

        yield 'conditionIdWrongType' => [
            [...$base, ConditionDistributionTransformerInterface::KEY_CONDITION_ID => 42],
            static function (ConditionDistributionInterface $model): void {
                self::assertNull($model->getConditionId());
            },
        ];

        yield 'matchCountWrongType' => [
            [...$base, ConditionDistributionTransformerInterface::KEY_MATCH_COUNT => 'x'],
            static function (ConditionDistributionInterface $model): void {
                self::assertNull($model->getMatchCount());
            },
        ];

        yield 'matchCountZero' => [
            [...$base, ConditionDistributionTransformerInterface::KEY_MATCH_COUNT => 0],
            static function (ConditionDistributionInterface $model): void {
                self::assertSame(0, $model->getMatchCount());
            },
        ];

        yield 'refinementHrefWrongType' => [
            [...$base, ConditionDistributionTransformerInterface::KEY_REFINEMENT_HREF => 42],
            static function (ConditionDistributionInterface $model): void {
                self::assertNull($model->getRefinementHref());
            },
        ];
    }

    private function buildTransformer(): ConditionDistributionTransformer
    {
        return new ConditionDistributionTransformer();
    }
}

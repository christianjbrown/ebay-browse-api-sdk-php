<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\AspectValueDistribution;
use ChristianBrown\EBay\Browse\Model\AspectValueDistributionInterface;
use ChristianBrown\EBay\Browse\Transformer\AspectValueDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectValueDistributionTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(AspectValueDistribution::class)]
#[CoversClass(AspectValueDistributionTransformer::class)]
final class AspectValueDistributionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            AspectValueDistributionTransformerInterface::KEY_LOCALIZED_ASPECT_VALUE => 'v_0',
            AspectValueDistributionTransformerInterface::KEY_MATCH_COUNT => 101,
            AspectValueDistributionTransformerInterface::KEY_REFINEMENT_HREF => 'v_2',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getLocalizedAspectValue());
        self::assertSame(101, $actual->getMatchCount());
        self::assertSame('v_2', $actual->getRefinementHref());
    }

    /**
     * @param array<string, mixed>                            $data
     * @param Closure(AspectValueDistributionInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(AspectValueDistributionInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (AspectValueDistributionInterface $model): void {
                self::assertNull($model->getLocalizedAspectValue());
                self::assertNull($model->getMatchCount());
                self::assertNull($model->getRefinementHref());
            },
        ];

        yield 'localizedAspectValueWrongType' => [
            [...$base, AspectValueDistributionTransformerInterface::KEY_LOCALIZED_ASPECT_VALUE => 42],
            static function (AspectValueDistributionInterface $model): void {
                self::assertNull($model->getLocalizedAspectValue());
            },
        ];

        yield 'matchCountWrongType' => [
            [...$base, AspectValueDistributionTransformerInterface::KEY_MATCH_COUNT => 'x'],
            static function (AspectValueDistributionInterface $model): void {
                self::assertNull($model->getMatchCount());
            },
        ];

        yield 'matchCountZero' => [
            [...$base, AspectValueDistributionTransformerInterface::KEY_MATCH_COUNT => 0],
            static function (AspectValueDistributionInterface $model): void {
                self::assertSame(0, $model->getMatchCount());
            },
        ];

        yield 'refinementHrefWrongType' => [
            [...$base, AspectValueDistributionTransformerInterface::KEY_REFINEMENT_HREF => 42],
            static function (AspectValueDistributionInterface $model): void {
                self::assertNull($model->getRefinementHref());
            },
        ];
    }

    private function buildTransformer(): AspectValueDistributionTransformer
    {
        return new AspectValueDistributionTransformer();
    }
}

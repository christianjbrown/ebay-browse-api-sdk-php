<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\BuyingOptionDistribution;
use ChristianBrown\EBay\Browse\Model\BuyingOptionDistributionInterface;
use ChristianBrown\EBay\Browse\Transformer\BuyingOptionDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\BuyingOptionDistributionTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BuyingOptionDistribution::class)]
#[CoversClass(BuyingOptionDistributionTransformer::class)]
final class BuyingOptionDistributionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            BuyingOptionDistributionTransformerInterface::KEY_BUYING_OPTION => 'v_0',
            BuyingOptionDistributionTransformerInterface::KEY_MATCH_COUNT => 101,
            BuyingOptionDistributionTransformerInterface::KEY_REFINEMENT_HREF => 'v_2',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getBuyingOption());
        self::assertSame(101, $actual->getMatchCount());
        self::assertSame('v_2', $actual->getRefinementHref());
    }

    /**
     * @param array<string, mixed>                             $data
     * @param Closure(BuyingOptionDistributionInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(BuyingOptionDistributionInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (BuyingOptionDistributionInterface $model): void {
                self::assertNull($model->getBuyingOption());
                self::assertNull($model->getMatchCount());
                self::assertNull($model->getRefinementHref());
            },
        ];

        yield 'buyingOptionWrongType' => [
            [...$base, BuyingOptionDistributionTransformerInterface::KEY_BUYING_OPTION => 42],
            static function (BuyingOptionDistributionInterface $model): void {
                self::assertNull($model->getBuyingOption());
            },
        ];

        yield 'matchCountWrongType' => [
            [...$base, BuyingOptionDistributionTransformerInterface::KEY_MATCH_COUNT => 'x'],
            static function (BuyingOptionDistributionInterface $model): void {
                self::assertNull($model->getMatchCount());
            },
        ];

        yield 'matchCountZero' => [
            [...$base, BuyingOptionDistributionTransformerInterface::KEY_MATCH_COUNT => 0],
            static function (BuyingOptionDistributionInterface $model): void {
                self::assertSame(0, $model->getMatchCount());
            },
        ];

        yield 'refinementHrefWrongType' => [
            [...$base, BuyingOptionDistributionTransformerInterface::KEY_REFINEMENT_HREF => 42],
            static function (BuyingOptionDistributionInterface $model): void {
                self::assertNull($model->getRefinementHref());
            },
        ];
    }

    private function buildTransformer(): BuyingOptionDistributionTransformer
    {
        return new BuyingOptionDistributionTransformer();
    }
}

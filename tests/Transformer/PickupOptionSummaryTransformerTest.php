<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\PickupOptionSummary;
use ChristianBrown\EBay\Browse\Model\PickupOptionSummaryInterface;
use ChristianBrown\EBay\Browse\Transformer\PickupOptionSummaryTransformer;
use ChristianBrown\EBay\Browse\Transformer\PickupOptionSummaryTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PickupOptionSummary::class)]
#[CoversClass(PickupOptionSummaryTransformer::class)]
final class PickupOptionSummaryTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            PickupOptionSummaryTransformerInterface::KEY_PICKUP_LOCATION_TYPE => 'v_1',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getPickupLocationType());
    }

    /**
     * @param array<string, mixed>                        $data
     * @param Closure(PickupOptionSummaryInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(PickupOptionSummaryInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (PickupOptionSummaryInterface $model): void {
                self::assertNull($model->getPickupLocationType());
            },
        ];

        yield 'pickupLocationTypeWrongType' => [
            [...$base, PickupOptionSummaryTransformerInterface::KEY_PICKUP_LOCATION_TYPE => 42],
            static function (PickupOptionSummaryInterface $model): void {
                self::assertNull($model->getPickupLocationType());
            },
        ];
    }

    private function buildTransformer(): PickupOptionSummaryTransformer
    {

        return new PickupOptionSummaryTransformer();
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\AspectDistribution;
use ChristianBrown\EBay\Browse\Model\AspectDistributionInterface;
use ChristianBrown\EBay\Browse\Model\AspectValueDistributionInterface;
use ChristianBrown\EBay\Browse\Transformer\AspectDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectDistributionTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\AspectValueDistributionsTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(AspectDistribution::class)]
#[CoversClass(AspectDistributionTransformer::class)]
final class AspectDistributionTransformerTest extends TestCase
{
    private ?AspectValueDistributionInterface $aspectValueDistribution = null;

    public function testTransform(): void
    {
        $data = [
            AspectDistributionTransformerInterface::KEY_ASPECT_VALUE_DISTRIBUTIONS => ['raw_aspectValueDistributions'],
            AspectDistributionTransformerInterface::KEY_LOCALIZED_ASPECT_NAME => 'v_1',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame([$this->aspectValueDistribution], $actual->getAspectValueDistributions());
        self::assertSame('v_1', $actual->getLocalizedAspectName());
    }

    /**
     * @param array<string, mixed>                       $data
     * @param Closure(AspectDistributionInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(AspectDistributionInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (AspectDistributionInterface $model): void {
                self::assertSame([], $model->getAspectValueDistributions());
                self::assertNull($model->getLocalizedAspectName());
            },
        ];

        yield 'aspectValueDistributionsWrongType' => [
            [...$base, AspectDistributionTransformerInterface::KEY_ASPECT_VALUE_DISTRIBUTIONS => 'x'],
            static function (AspectDistributionInterface $model): void {
                self::assertSame([], $model->getAspectValueDistributions());
            },
        ];

        yield 'localizedAspectNameWrongType' => [
            [...$base, AspectDistributionTransformerInterface::KEY_LOCALIZED_ASPECT_NAME => 42],
            static function (AspectDistributionInterface $model): void {
                self::assertNull($model->getLocalizedAspectName());
            },
        ];
    }

    private function buildTransformer(): AspectDistributionTransformer
    {
        $this->aspectValueDistribution = self::createStub(AspectValueDistributionInterface::class);

        $aspectValueDistributionsTransformer = self::createStub(AspectValueDistributionsTransformerInterface::class);
        $aspectValueDistributionsTransformer->method('transform')->willReturn([$this->aspectValueDistribution]);

        return new AspectDistributionTransformer($aspectValueDistributionsTransformer);
    }
}

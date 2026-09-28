<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\AddonService;
use ChristianBrown\EBay\Browse\Model\AddonServiceInterface;
use ChristianBrown\EBay\Browse\Model\ConvertedAmountInterface;
use ChristianBrown\EBay\Browse\Transformer\AddonServiceTransformer;
use ChristianBrown\EBay\Browse\Transformer\AddonServiceTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ConvertedAmountTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(AddonService::class)]
#[CoversClass(AddonServiceTransformer::class)]
final class AddonServiceTransformerTest extends TestCase
{
    private ?ConvertedAmountInterface $convertedAmount = null;

    public function testTransform(): void
    {
        $data = [
            AddonServiceTransformerInterface::KEY_SELECTION => 'v_1',
            AddonServiceTransformerInterface::KEY_SERVICE_FEE => ['raw_serviceFee'],
            AddonServiceTransformerInterface::KEY_SERVICE_ID => 'v_2',
            AddonServiceTransformerInterface::KEY_SERVICE_TYPE => 'v_3',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getSelection());
        self::assertSame($this->convertedAmount, $actual->getServiceFee());
        self::assertSame('v_2', $actual->getServiceId());
        self::assertSame('v_3', $actual->getServiceType());
    }

    /**
     * @param array<string, mixed>                 $data
     * @param Closure(AddonServiceInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(AddonServiceInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (AddonServiceInterface $model): void {
                self::assertNull($model->getSelection());
                self::assertNull($model->getServiceFee());
                self::assertNull($model->getServiceId());
                self::assertNull($model->getServiceType());
            },
        ];

        yield 'selectionWrongType' => [
            [...$base, AddonServiceTransformerInterface::KEY_SELECTION => 42],
            static function (AddonServiceInterface $model): void {
                self::assertNull($model->getSelection());
            },
        ];

        yield 'serviceFeeWrongType' => [
            [...$base, AddonServiceTransformerInterface::KEY_SERVICE_FEE => 'x'],
            static function (AddonServiceInterface $model): void {
                self::assertNull($model->getServiceFee());
            },
        ];

        yield 'serviceIdWrongType' => [
            [...$base, AddonServiceTransformerInterface::KEY_SERVICE_ID => 42],
            static function (AddonServiceInterface $model): void {
                self::assertNull($model->getServiceId());
            },
        ];

        yield 'serviceTypeWrongType' => [
            [...$base, AddonServiceTransformerInterface::KEY_SERVICE_TYPE => 42],
            static function (AddonServiceInterface $model): void {
                self::assertNull($model->getServiceType());
            },
        ];
    }

    private function buildTransformer(): AddonServiceTransformer
    {
        $this->convertedAmount = self::createStub(ConvertedAmountInterface::class);

        $convertedAmountTransformer = self::createStub(ConvertedAmountTransformerInterface::class);
        $convertedAmountTransformer->method('transform')->willReturn($this->convertedAmount);

        return new AddonServiceTransformer($convertedAmountTransformer);
    }
}

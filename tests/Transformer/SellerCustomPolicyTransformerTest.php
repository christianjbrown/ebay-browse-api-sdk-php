<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\SellerCustomPolicy;
use ChristianBrown\EBay\Browse\Model\SellerCustomPolicyInterface;
use ChristianBrown\EBay\Browse\Transformer\SellerCustomPolicyTransformer;
use ChristianBrown\EBay\Browse\Transformer\SellerCustomPolicyTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(SellerCustomPolicy::class)]
#[CoversClass(SellerCustomPolicyTransformer::class)]
final class SellerCustomPolicyTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            SellerCustomPolicyTransformerInterface::KEY_DESCRIPTION => 'v_1',
            SellerCustomPolicyTransformerInterface::KEY_LABEL => 'v_2',
            SellerCustomPolicyTransformerInterface::KEY_TYPE => 'v_3',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getDescription());
        self::assertSame('v_2', $actual->getLabel());
        self::assertSame('v_3', $actual->getType());
    }

    /**
     * @param array<string, mixed>                       $data
     * @param Closure(SellerCustomPolicyInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(SellerCustomPolicyInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (SellerCustomPolicyInterface $model): void {
                self::assertNull($model->getDescription());
                self::assertNull($model->getLabel());
                self::assertNull($model->getType());
            },
        ];

        yield 'descriptionWrongType' => [
            [...$base, SellerCustomPolicyTransformerInterface::KEY_DESCRIPTION => 42],
            static function (SellerCustomPolicyInterface $model): void {
                self::assertNull($model->getDescription());
            },
        ];

        yield 'labelWrongType' => [
            [...$base, SellerCustomPolicyTransformerInterface::KEY_LABEL => 42],
            static function (SellerCustomPolicyInterface $model): void {
                self::assertNull($model->getLabel());
            },
        ];

        yield 'typeWrongType' => [
            [...$base, SellerCustomPolicyTransformerInterface::KEY_TYPE => 42],
            static function (SellerCustomPolicyInterface $model): void {
                self::assertNull($model->getType());
            },
        ];
    }

    private function buildTransformer(): SellerCustomPolicyTransformer
    {

        return new SellerCustomPolicyTransformer();
    }
}

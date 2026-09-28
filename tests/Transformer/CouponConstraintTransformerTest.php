<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\CouponConstraint;
use ChristianBrown\EBay\Browse\Model\CouponConstraintInterface;
use ChristianBrown\EBay\Browse\Transformer\CouponConstraintTransformer;
use ChristianBrown\EBay\Browse\Transformer\CouponConstraintTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CouponConstraint::class)]
#[CoversClass(CouponConstraintTransformer::class)]
final class CouponConstraintTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            CouponConstraintTransformerInterface::KEY_EXPIRATION_DATE => 'v_1',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getExpirationDate());
    }

    /**
     * @param array<string, mixed>                     $data
     * @param Closure(CouponConstraintInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(CouponConstraintInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (CouponConstraintInterface $model): void {
                self::assertNull($model->getExpirationDate());
            },
        ];

        yield 'expirationDateWrongType' => [
            [...$base, CouponConstraintTransformerInterface::KEY_EXPIRATION_DATE => 42],
            static function (CouponConstraintInterface $model): void {
                self::assertNull($model->getExpirationDate());
            },
        ];
    }

    private function buildTransformer(): CouponConstraintTransformer
    {

        return new CouponConstraintTransformer();
    }
}

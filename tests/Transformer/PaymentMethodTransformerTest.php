<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\PaymentMethod;
use ChristianBrown\EBay\Browse\Model\PaymentMethodBrandInterface;
use ChristianBrown\EBay\Browse\Model\PaymentMethodInterface;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodBrandsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PaymentMethod::class)]
#[CoversClass(PaymentMethodTransformer::class)]
final class PaymentMethodTransformerTest extends TestCase
{
    private ?PaymentMethodBrandInterface $paymentMethodBrand = null;

    public function testTransform(): void
    {
        $data = [
            PaymentMethodTransformerInterface::KEY_PAYMENT_METHOD_BRANDS => ['raw_paymentMethodBrands'],
            PaymentMethodTransformerInterface::KEY_PAYMENT_METHOD_TYPE => 'v_1',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame([$this->paymentMethodBrand], $actual->getPaymentMethodBrands());
        self::assertSame('v_1', $actual->getPaymentMethodType());
    }

    /**
     * @param array<string, mixed>                  $data
     * @param Closure(PaymentMethodInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(PaymentMethodInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (PaymentMethodInterface $model): void {
                self::assertSame([], $model->getPaymentMethodBrands());
                self::assertNull($model->getPaymentMethodType());
            },
        ];

        yield 'paymentMethodBrandsWrongType' => [
            [...$base, PaymentMethodTransformerInterface::KEY_PAYMENT_METHOD_BRANDS => 'x'],
            static function (PaymentMethodInterface $model): void {
                self::assertSame([], $model->getPaymentMethodBrands());
            },
        ];

        yield 'paymentMethodTypeWrongType' => [
            [...$base, PaymentMethodTransformerInterface::KEY_PAYMENT_METHOD_TYPE => 42],
            static function (PaymentMethodInterface $model): void {
                self::assertNull($model->getPaymentMethodType());
            },
        ];
    }

    private function buildTransformer(): PaymentMethodTransformer
    {
        $this->paymentMethodBrand = self::createStub(PaymentMethodBrandInterface::class);

        $paymentMethodBrandsTransformer = self::createStub(PaymentMethodBrandsTransformerInterface::class);
        $paymentMethodBrandsTransformer->method('transform')->willReturn([$this->paymentMethodBrand]);

        return new PaymentMethodTransformer($paymentMethodBrandsTransformer);
    }
}

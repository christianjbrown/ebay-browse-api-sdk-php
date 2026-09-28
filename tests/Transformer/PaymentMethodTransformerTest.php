<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\PaymentMethod;
use ChristianBrown\EBay\Browse\Model\PaymentMethodBrandInterface;
use ChristianBrown\EBay\Browse\Model\PaymentMethodInterface;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodBrandsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformerInterface;
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
            PaymentMethodTransformerInterface::KEY_PAYMENT_INSTRUCTIONS => ['raw_paymentInstructions'],
            PaymentMethodTransformerInterface::KEY_PAYMENT_METHOD_BRANDS => ['raw_paymentMethodBrands'],
            PaymentMethodTransformerInterface::KEY_PAYMENT_METHOD_TYPE => 'v_1',
            PaymentMethodTransformerInterface::KEY_SELLER_INSTRUCTIONS => ['raw_sellerInstructions'],
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(['s'], $actual->getPaymentInstructions());
        self::assertSame([$this->paymentMethodBrand], $actual->getPaymentMethodBrands());
        self::assertSame('v_1', $actual->getPaymentMethodType());
        self::assertSame(['s'], $actual->getSellerInstructions());
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
                self::assertSame([], $model->getPaymentInstructions());
                self::assertSame([], $model->getPaymentMethodBrands());
                self::assertNull($model->getPaymentMethodType());
                self::assertSame([], $model->getSellerInstructions());
            },
        ];

        yield 'paymentInstructionsWrongType' => [
            [...$base, PaymentMethodTransformerInterface::KEY_PAYMENT_INSTRUCTIONS => 'x'],
            static function (PaymentMethodInterface $model): void {
                self::assertSame([], $model->getPaymentInstructions());
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

        yield 'sellerInstructionsWrongType' => [
            [...$base, PaymentMethodTransformerInterface::KEY_SELLER_INSTRUCTIONS => 'x'],
            static function (PaymentMethodInterface $model): void {
                self::assertSame([], $model->getSellerInstructions());
            },
        ];
    }

    private function buildTransformer(): PaymentMethodTransformer
    {
        $this->paymentMethodBrand = self::createStub(PaymentMethodBrandInterface::class);

        $paymentMethodBrandsTransformer = self::createStub(PaymentMethodBrandsTransformerInterface::class);
        $paymentMethodBrandsTransformer->method('transform')->willReturn([$this->paymentMethodBrand]);
        $stringsTransformer = self::createStub(StringsTransformerInterface::class);
        $stringsTransformer->method('transform')->willReturn(['s']);

        return new PaymentMethodTransformer($paymentMethodBrandsTransformer, $stringsTransformer);
    }
}

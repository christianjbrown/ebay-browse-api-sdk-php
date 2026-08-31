<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ImageInterface;
use ChristianBrown\EBay\Browse\Model\PaymentMethodBrand;
use ChristianBrown\EBay\Browse\Model\PaymentMethodBrandInterface;
use ChristianBrown\EBay\Browse\Transformer\ImageTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodBrandTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodBrandTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PaymentMethodBrand::class)]
#[CoversClass(PaymentMethodBrandTransformer::class)]
final class PaymentMethodBrandTransformerTest extends TestCase
{
    private ?ImageInterface $image = null;

    public function testTransform(): void
    {
        $data = [
            PaymentMethodBrandTransformerInterface::KEY_LOGO_IMAGE => ['raw_logoImage'],
            PaymentMethodBrandTransformerInterface::KEY_PAYMENT_METHOD_BRAND_TYPE => 'v_1',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($this->image, $actual->getLogoImage());
        self::assertSame('v_1', $actual->getPaymentMethodBrandType());
    }

    /**
     * @param array<string, mixed>                       $data
     * @param Closure(PaymentMethodBrandInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(PaymentMethodBrandInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (PaymentMethodBrandInterface $model): void {
                self::assertNull($model->getLogoImage());
                self::assertNull($model->getPaymentMethodBrandType());
            },
        ];

        yield 'logoImageWrongType' => [
            [...$base, PaymentMethodBrandTransformerInterface::KEY_LOGO_IMAGE => 'x'],
            static function (PaymentMethodBrandInterface $model): void {
                self::assertNull($model->getLogoImage());
            },
        ];

        yield 'paymentMethodBrandTypeWrongType' => [
            [...$base, PaymentMethodBrandTransformerInterface::KEY_PAYMENT_METHOD_BRAND_TYPE => 42],
            static function (PaymentMethodBrandInterface $model): void {
                self::assertNull($model->getPaymentMethodBrandType());
            },
        ];
    }

    private function buildTransformer(): PaymentMethodBrandTransformer
    {
        $this->image = self::createStub(ImageInterface::class);

        $imageTransformer = self::createStub(ImageTransformerInterface::class);
        $imageTransformer->method('transform')->willReturn($this->image);

        return new PaymentMethodBrandTransformer($imageTransformer);
    }
}

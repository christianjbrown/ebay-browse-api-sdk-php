<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\PaymentMethodBrand;
use ChristianBrown\EBay\Browse\Model\PaymentMethodBrandInterface;

use function is_array;
use function is_string;

final class PaymentMethodBrandTransformer implements PaymentMethodBrandTransformerInterface
{
    private ImageTransformerInterface $imageTransformer;

    public function __construct(ImageTransformerInterface $imageTransformer)
    {
        $this->imageTransformer = $imageTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentMethodBrandInterface
    {
        $paymentMethodBrand = new PaymentMethodBrand();

        $this->applyLogoImage($paymentMethodBrand, $data);
        self::applyPaymentMethodBrandType($paymentMethodBrand, $data);

        return $paymentMethodBrand;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLogoImage(PaymentMethodBrand $paymentMethodBrand, array $data): void
    {
        if (empty($data[self::KEY_LOGO_IMAGE])) {
            return;
        }
        if (!is_array($data[self::KEY_LOGO_IMAGE])) {
            return;
        }
        $paymentMethodBrand->setLogoImage($this->imageTransformer->transform($data[self::KEY_LOGO_IMAGE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPaymentMethodBrandType(PaymentMethodBrand $paymentMethodBrand, array $data): void
    {
        if (empty($data[self::KEY_PAYMENT_METHOD_BRAND_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_PAYMENT_METHOD_BRAND_TYPE])) {
            return;
        }
        $paymentMethodBrand->setPaymentMethodBrandType($data[self::KEY_PAYMENT_METHOD_BRAND_TYPE]);
    }
}

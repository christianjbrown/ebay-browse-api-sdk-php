<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\PaymentMethod;
use ChristianBrown\EBay\Browse\Model\PaymentMethodInterface;

use function is_array;
use function is_string;

final class PaymentMethodTransformer implements PaymentMethodTransformerInterface
{
    private PaymentMethodBrandsTransformerInterface $paymentMethodBrandsTransformer;
    private StringsTransformerInterface $stringsTransformer;

    public function __construct(PaymentMethodBrandsTransformerInterface $paymentMethodBrandsTransformer, StringsTransformerInterface $stringsTransformer)
    {
        $this->paymentMethodBrandsTransformer = $paymentMethodBrandsTransformer;
        $this->stringsTransformer = $stringsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentMethodInterface
    {
        $paymentMethod = new PaymentMethod();

        $this->applyPaymentInstructions($paymentMethod, $data);
        $this->applyPaymentMethodBrands($paymentMethod, $data);
        self::applyPaymentMethodType($paymentMethod, $data);
        $this->applySellerInstructions($paymentMethod, $data);

        return $paymentMethod;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPaymentInstructions(PaymentMethod $paymentMethod, array $data): void
    {
        if (empty($data[self::KEY_PAYMENT_INSTRUCTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_PAYMENT_INSTRUCTIONS])) {
            return;
        }
        $paymentMethod->setPaymentInstructions($this->stringsTransformer->transform($data[self::KEY_PAYMENT_INSTRUCTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPaymentMethodBrands(PaymentMethod $paymentMethod, array $data): void
    {
        if (empty($data[self::KEY_PAYMENT_METHOD_BRANDS])) {
            return;
        }
        if (!is_array($data[self::KEY_PAYMENT_METHOD_BRANDS])) {
            return;
        }
        $paymentMethod->setPaymentMethodBrands($this->paymentMethodBrandsTransformer->transform($data[self::KEY_PAYMENT_METHOD_BRANDS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPaymentMethodType(PaymentMethod $paymentMethod, array $data): void
    {
        if (empty($data[self::KEY_PAYMENT_METHOD_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_PAYMENT_METHOD_TYPE])) {
            return;
        }
        $paymentMethod->setPaymentMethodType($data[self::KEY_PAYMENT_METHOD_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySellerInstructions(PaymentMethod $paymentMethod, array $data): void
    {
        if (empty($data[self::KEY_SELLER_INSTRUCTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_SELLER_INSTRUCTIONS])) {
            return;
        }
        $paymentMethod->setSellerInstructions($this->stringsTransformer->transform($data[self::KEY_SELLER_INSTRUCTIONS]));
    }
}

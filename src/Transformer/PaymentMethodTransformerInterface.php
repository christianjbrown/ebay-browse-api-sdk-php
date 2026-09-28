<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\PaymentMethodInterface;

interface PaymentMethodTransformerInterface
{
    public const string KEY_PAYMENT_INSTRUCTIONS = 'paymentInstructions';
    public const string KEY_PAYMENT_METHOD_BRANDS = 'paymentMethodBrands';
    public const string KEY_PAYMENT_METHOD_TYPE = 'paymentMethodType';
    public const string KEY_SELLER_INSTRUCTIONS = 'sellerInstructions';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentMethodInterface;
}

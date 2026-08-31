<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\PaymentMethodInterface;

interface PaymentMethodTransformerInterface
{
    public const string KEY_PAYMENT_METHOD_BRANDS = 'paymentMethodBrands';
    public const string KEY_PAYMENT_METHOD_TYPE = 'paymentMethodType';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentMethodInterface;
}

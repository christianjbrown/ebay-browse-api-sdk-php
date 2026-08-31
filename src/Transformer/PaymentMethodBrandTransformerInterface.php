<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\PaymentMethodBrandInterface;

interface PaymentMethodBrandTransformerInterface
{
    public const string KEY_LOGO_IMAGE = 'logoImage';
    public const string KEY_PAYMENT_METHOD_BRAND_TYPE = 'paymentMethodBrandType';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentMethodBrandInterface;
}

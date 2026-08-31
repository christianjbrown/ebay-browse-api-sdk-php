<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class PaymentMethodBrand implements PaymentMethodBrandInterface
{
    private ?ImageInterface $logoImage = null;
    private ?string $paymentMethodBrandType = null;

    public function getLogoImage(): ?ImageInterface
    {
        return $this->logoImage;
    }

    public function getPaymentMethodBrandType(): ?string
    {
        return $this->paymentMethodBrandType;
    }

    public function setLogoImage(?ImageInterface $value): PaymentMethodBrandInterface
    {
        $this->logoImage = $value;

        return $this;
    }

    public function setPaymentMethodBrandType(?string $value): PaymentMethodBrandInterface
    {
        $this->paymentMethodBrandType = $value;

        return $this;
    }
}

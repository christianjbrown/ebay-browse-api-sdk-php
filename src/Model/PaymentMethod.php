<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class PaymentMethod implements PaymentMethodInterface
{
    /**
     * @var array<int, PaymentMethodBrandInterface>
     */
    private array $paymentMethodBrands = [];
    private ?string $paymentMethodType = null;

    /**
     * @return array<int, PaymentMethodBrandInterface>
     */
    public function getPaymentMethodBrands(): array
    {
        return $this->paymentMethodBrands;
    }

    public function getPaymentMethodType(): ?string
    {
        return $this->paymentMethodType;
    }

    /**
     * @param array<int, PaymentMethodBrandInterface> $value
     */
    public function setPaymentMethodBrands(array $value): PaymentMethodInterface
    {
        $this->paymentMethodBrands = $value;

        return $this;
    }

    public function setPaymentMethodType(?string $value): PaymentMethodInterface
    {
        $this->paymentMethodType = $value;

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface PaymentMethodInterface
{
    /**
     * @return array<int, PaymentMethodBrandInterface>
     */
    public function getPaymentMethodBrands(): array;

    public function getPaymentMethodType(): ?string;

    /**
     * @param array<int, PaymentMethodBrandInterface> $value
     */
    public function setPaymentMethodBrands(array $value): self;

    public function setPaymentMethodType(?string $value): self;
}

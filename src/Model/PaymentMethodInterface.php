<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface PaymentMethodInterface
{
    /**
     * @return array<int, string>
     */
    public function getPaymentInstructions(): array;

    /**
     * @return array<int, PaymentMethodBrandInterface>
     */
    public function getPaymentMethodBrands(): array;

    public function getPaymentMethodType(): ?string;

    /**
     * @return array<int, string>
     */
    public function getSellerInstructions(): array;

    /**
     * @param array<int, string> $value
     */
    public function setPaymentInstructions(array $value): self;

    /**
     * @param array<int, PaymentMethodBrandInterface> $value
     */
    public function setPaymentMethodBrands(array $value): self;

    public function setPaymentMethodType(?string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setSellerInstructions(array $value): self;
}

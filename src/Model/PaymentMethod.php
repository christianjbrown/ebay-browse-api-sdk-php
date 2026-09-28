<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class PaymentMethod implements PaymentMethodInterface
{
    /**
     * @var array<int, string>
     */
    private array $paymentInstructions = [];

    /**
     * @var array<int, PaymentMethodBrandInterface>
     */
    private array $paymentMethodBrands = [];
    private ?string $paymentMethodType = null;

    /**
     * @var array<int, string>
     */
    private array $sellerInstructions = [];

    /**
     * @return array<int, string>
     */
    public function getPaymentInstructions(): array
    {
        return $this->paymentInstructions;
    }

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
     * @return array<int, string>
     */
    public function getSellerInstructions(): array
    {
        return $this->sellerInstructions;
    }

    /**
     * @param array<int, string> $value
     */
    public function setPaymentInstructions(array $value): PaymentMethodInterface
    {
        $this->paymentInstructions = $value;

        return $this;
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

    /**
     * @param array<int, string> $value
     */
    public function setSellerInstructions(array $value): PaymentMethodInterface
    {
        $this->sellerInstructions = $value;

        return $this;
    }
}

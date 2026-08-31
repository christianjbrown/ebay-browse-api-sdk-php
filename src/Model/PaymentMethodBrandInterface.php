<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface PaymentMethodBrandInterface
{
    public function getLogoImage(): ?ImageInterface;

    public function getPaymentMethodBrandType(): ?string;

    public function setLogoImage(?ImageInterface $value): self;

    public function setPaymentMethodBrandType(?string $value): self;
}

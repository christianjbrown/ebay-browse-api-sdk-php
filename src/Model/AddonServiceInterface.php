<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface AddonServiceInterface
{
    public function getSelection(): ?string;

    public function getServiceFee(): ?ConvertedAmountInterface;

    public function getServiceId(): ?string;

    public function getServiceType(): ?string;

    public function setSelection(?string $value): self;

    public function setServiceFee(?ConvertedAmountInterface $value): self;

    public function setServiceId(?string $value): self;

    public function setServiceType(?string $value): self;
}

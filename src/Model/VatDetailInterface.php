<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface VatDetailInterface
{
    public function getIssuingCountry(): ?string;

    public function getVatId(): ?string;

    public function setIssuingCountry(?string $value): self;

    public function setVatId(?string $value): self;
}

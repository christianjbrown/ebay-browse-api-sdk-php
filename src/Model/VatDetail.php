<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class VatDetail implements VatDetailInterface
{
    private ?string $issuingCountry = null;
    private ?string $vatId = null;

    public function getIssuingCountry(): ?string
    {
        return $this->issuingCountry;
    }

    public function getVatId(): ?string
    {
        return $this->vatId;
    }

    public function setIssuingCountry(?string $value): VatDetailInterface
    {
        $this->issuingCountry = $value;

        return $this;
    }

    public function setVatId(?string $value): VatDetailInterface
    {
        $this->vatId = $value;

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class ShipToLocation implements ShipToLocationInterface
{
    private ?string $country = null;
    private ?string $postalCode = null;

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setCountry(?string $value): ShipToLocationInterface
    {
        $this->country = $value;

        return $this;
    }

    public function setPostalCode(?string $value): ShipToLocationInterface
    {
        $this->postalCode = $value;

        return $this;
    }
}

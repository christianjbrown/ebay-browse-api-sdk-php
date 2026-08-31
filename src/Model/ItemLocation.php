<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class ItemLocation implements ItemLocationInterface
{
    private ?string $addressLine1 = null;
    private ?string $addressLine2 = null;
    private ?string $city = null;
    private string $country;
    private ?string $county = null;
    private ?string $postalCode = null;
    private ?string $stateOrProvince = null;

    public function __construct(string $country)
    {
        $this->country = $country;
    }

    public function getAddressLine1(): ?string
    {
        return $this->addressLine1;
    }

    public function getAddressLine2(): ?string
    {
        return $this->addressLine2;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCounty(): ?string
    {
        return $this->county;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function getStateOrProvince(): ?string
    {
        return $this->stateOrProvince;
    }

    public function setAddressLine1(?string $value): ItemLocationInterface
    {
        $this->addressLine1 = $value;

        return $this;
    }

    public function setAddressLine2(?string $value): ItemLocationInterface
    {
        $this->addressLine2 = $value;

        return $this;
    }

    public function setCity(?string $value): ItemLocationInterface
    {
        $this->city = $value;

        return $this;
    }

    public function setCountry(string $value): ItemLocationInterface
    {
        $this->country = $value;

        return $this;
    }

    public function setCounty(?string $value): ItemLocationInterface
    {
        $this->county = $value;

        return $this;
    }

    public function setPostalCode(?string $value): ItemLocationInterface
    {
        $this->postalCode = $value;

        return $this;
    }

    public function setStateOrProvince(?string $value): ItemLocationInterface
    {
        $this->stateOrProvince = $value;

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class LegalAddress implements LegalAddressInterface
{
    private ?string $addressLine1 = null;
    private ?string $addressLine2 = null;
    private ?string $city = null;
    private ?string $country = null;
    private ?string $countryName = null;
    private ?string $county = null;
    private ?string $postalCode = null;
    private ?string $stateOrProvince = null;

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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getCountryName(): ?string
    {
        return $this->countryName;
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

    public function setAddressLine1(?string $value): LegalAddressInterface
    {
        $this->addressLine1 = $value;

        return $this;
    }

    public function setAddressLine2(?string $value): LegalAddressInterface
    {
        $this->addressLine2 = $value;

        return $this;
    }

    public function setCity(?string $value): LegalAddressInterface
    {
        $this->city = $value;

        return $this;
    }

    public function setCountry(?string $value): LegalAddressInterface
    {
        $this->country = $value;

        return $this;
    }

    public function setCountryName(?string $value): LegalAddressInterface
    {
        $this->countryName = $value;

        return $this;
    }

    public function setCounty(?string $value): LegalAddressInterface
    {
        $this->county = $value;

        return $this;
    }

    public function setPostalCode(?string $value): LegalAddressInterface
    {
        $this->postalCode = $value;

        return $this;
    }

    public function setStateOrProvince(?string $value): LegalAddressInterface
    {
        $this->stateOrProvince = $value;

        return $this;
    }
}

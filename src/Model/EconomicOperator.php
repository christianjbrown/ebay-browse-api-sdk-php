<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class EconomicOperator implements EconomicOperatorInterface
{
    private ?string $addressLine1 = null;
    private ?string $addressLine2 = null;
    private ?string $city = null;
    private ?string $companyName = null;
    private ?string $country = null;
    private ?string $email = null;
    private ?string $phone = null;
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

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function getStateOrProvince(): ?string
    {
        return $this->stateOrProvince;
    }

    public function setAddressLine1(?string $value): EconomicOperatorInterface
    {
        $this->addressLine1 = $value;

        return $this;
    }

    public function setAddressLine2(?string $value): EconomicOperatorInterface
    {
        $this->addressLine2 = $value;

        return $this;
    }

    public function setCity(?string $value): EconomicOperatorInterface
    {
        $this->city = $value;

        return $this;
    }

    public function setCompanyName(?string $value): EconomicOperatorInterface
    {
        $this->companyName = $value;

        return $this;
    }

    public function setCountry(?string $value): EconomicOperatorInterface
    {
        $this->country = $value;

        return $this;
    }

    public function setEmail(?string $value): EconomicOperatorInterface
    {
        $this->email = $value;

        return $this;
    }

    public function setPhone(?string $value): EconomicOperatorInterface
    {
        $this->phone = $value;

        return $this;
    }

    public function setPostalCode(?string $value): EconomicOperatorInterface
    {
        $this->postalCode = $value;

        return $this;
    }

    public function setStateOrProvince(?string $value): EconomicOperatorInterface
    {
        $this->stateOrProvince = $value;

        return $this;
    }
}

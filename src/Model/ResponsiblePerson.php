<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class ResponsiblePerson implements ResponsiblePersonInterface
{
    private ?string $addressLine1 = null;
    private ?string $addressLine2 = null;
    private ?string $city = null;
    private ?string $companyName = null;
    private ?string $contactUrl = null;
    private ?string $country = null;
    private ?string $countryName = null;
    private ?string $county = null;
    private ?string $email = null;
    private ?string $phone = null;
    private ?string $postalCode = null;
    private ?string $stateOrProvince = null;

    /**
     * @var array<int, string>
     */
    private array $types = [];

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

    public function getContactUrl(): ?string
    {
        return $this->contactUrl;
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

    /**
     * @return array<int, string>
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    public function setAddressLine1(?string $value): ResponsiblePersonInterface
    {
        $this->addressLine1 = $value;

        return $this;
    }

    public function setAddressLine2(?string $value): ResponsiblePersonInterface
    {
        $this->addressLine2 = $value;

        return $this;
    }

    public function setCity(?string $value): ResponsiblePersonInterface
    {
        $this->city = $value;

        return $this;
    }

    public function setCompanyName(?string $value): ResponsiblePersonInterface
    {
        $this->companyName = $value;

        return $this;
    }

    public function setContactUrl(?string $value): ResponsiblePersonInterface
    {
        $this->contactUrl = $value;

        return $this;
    }

    public function setCountry(?string $value): ResponsiblePersonInterface
    {
        $this->country = $value;

        return $this;
    }

    public function setCountryName(?string $value): ResponsiblePersonInterface
    {
        $this->countryName = $value;

        return $this;
    }

    public function setCounty(?string $value): ResponsiblePersonInterface
    {
        $this->county = $value;

        return $this;
    }

    public function setEmail(?string $value): ResponsiblePersonInterface
    {
        $this->email = $value;

        return $this;
    }

    public function setPhone(?string $value): ResponsiblePersonInterface
    {
        $this->phone = $value;

        return $this;
    }

    public function setPostalCode(?string $value): ResponsiblePersonInterface
    {
        $this->postalCode = $value;

        return $this;
    }

    public function setStateOrProvince(?string $value): ResponsiblePersonInterface
    {
        $this->stateOrProvince = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setTypes(array $value): ResponsiblePersonInterface
    {
        $this->types = $value;

        return $this;
    }
}

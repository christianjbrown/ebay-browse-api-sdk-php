<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class SellerLegalInfo implements SellerLegalInfoInterface
{
    private ?EconomicOperatorInterface $economicOperator = null;
    private ?string $email = null;
    private ?string $fax = null;
    private ?string $imprint = null;
    private ?string $legalContactFirstName = null;
    private ?string $legalContactLastName = null;
    private ?string $name = null;
    private ?string $phone = null;
    private ?string $registrationNumber = null;
    private ?LegalAddressInterface $sellerProvidedLegalAddress = null;
    private ?string $termsOfService = null;

    /**
     * @var array<int, VatDetailInterface>
     */
    private array $vatDetails = [];
    private ?string $weeeNumber = null;

    public function getEconomicOperator(): ?EconomicOperatorInterface
    {
        return $this->economicOperator;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function getImprint(): ?string
    {
        return $this->imprint;
    }

    public function getLegalContactFirstName(): ?string
    {
        return $this->legalContactFirstName;
    }

    public function getLegalContactLastName(): ?string
    {
        return $this->legalContactLastName;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    public function getSellerProvidedLegalAddress(): ?LegalAddressInterface
    {
        return $this->sellerProvidedLegalAddress;
    }

    public function getTermsOfService(): ?string
    {
        return $this->termsOfService;
    }

    /**
     * @return array<int, VatDetailInterface>
     */
    public function getVatDetails(): array
    {
        return $this->vatDetails;
    }

    public function getWeeeNumber(): ?string
    {
        return $this->weeeNumber;
    }

    public function setEconomicOperator(?EconomicOperatorInterface $value): SellerLegalInfoInterface
    {
        $this->economicOperator = $value;

        return $this;
    }

    public function setEmail(?string $value): SellerLegalInfoInterface
    {
        $this->email = $value;

        return $this;
    }

    public function setFax(?string $value): SellerLegalInfoInterface
    {
        $this->fax = $value;

        return $this;
    }

    public function setImprint(?string $value): SellerLegalInfoInterface
    {
        $this->imprint = $value;

        return $this;
    }

    public function setLegalContactFirstName(?string $value): SellerLegalInfoInterface
    {
        $this->legalContactFirstName = $value;

        return $this;
    }

    public function setLegalContactLastName(?string $value): SellerLegalInfoInterface
    {
        $this->legalContactLastName = $value;

        return $this;
    }

    public function setName(?string $value): SellerLegalInfoInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setPhone(?string $value): SellerLegalInfoInterface
    {
        $this->phone = $value;

        return $this;
    }

    public function setRegistrationNumber(?string $value): SellerLegalInfoInterface
    {
        $this->registrationNumber = $value;

        return $this;
    }

    public function setSellerProvidedLegalAddress(?LegalAddressInterface $value): SellerLegalInfoInterface
    {
        $this->sellerProvidedLegalAddress = $value;

        return $this;
    }

    public function setTermsOfService(?string $value): SellerLegalInfoInterface
    {
        $this->termsOfService = $value;

        return $this;
    }

    /**
     * @param array<int, VatDetailInterface> $value
     */
    public function setVatDetails(array $value): SellerLegalInfoInterface
    {
        $this->vatDetails = $value;

        return $this;
    }

    public function setWeeeNumber(?string $value): SellerLegalInfoInterface
    {
        $this->weeeNumber = $value;

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface SellerLegalInfoInterface
{
    public function getEconomicOperator(): ?EconomicOperatorInterface;

    public function getEmail(): ?string;

    public function getFax(): ?string;

    public function getImprint(): ?string;

    public function getLegalContactFirstName(): ?string;

    public function getLegalContactLastName(): ?string;

    public function getName(): ?string;

    public function getPhone(): ?string;

    public function getRegistrationNumber(): ?string;

    public function getSellerProvidedLegalAddress(): ?LegalAddressInterface;

    public function getTermsOfService(): ?string;

    /**
     * @return array<int, VatDetailInterface>
     */
    public function getVatDetails(): array;

    public function getWeeeNumber(): ?string;

    public function setEconomicOperator(?EconomicOperatorInterface $value): self;

    public function setEmail(?string $value): self;

    public function setFax(?string $value): self;

    public function setImprint(?string $value): self;

    public function setLegalContactFirstName(?string $value): self;

    public function setLegalContactLastName(?string $value): self;

    public function setName(?string $value): self;

    public function setPhone(?string $value): self;

    public function setRegistrationNumber(?string $value): self;

    public function setSellerProvidedLegalAddress(?LegalAddressInterface $value): self;

    public function setTermsOfService(?string $value): self;

    /**
     * @param array<int, VatDetailInterface> $value
     */
    public function setVatDetails(array $value): self;

    public function setWeeeNumber(?string $value): self;
}

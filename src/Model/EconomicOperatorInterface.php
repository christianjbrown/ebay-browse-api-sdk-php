<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface EconomicOperatorInterface
{
    public function getAddressLine1(): ?string;

    public function getAddressLine2(): ?string;

    public function getCity(): ?string;

    public function getCompanyName(): ?string;

    public function getCountry(): ?string;

    public function getEmail(): ?string;

    public function getPhone(): ?string;

    public function getPostalCode(): ?string;

    public function getStateOrProvince(): ?string;

    public function setAddressLine1(?string $value): self;

    public function setAddressLine2(?string $value): self;

    public function setCity(?string $value): self;

    public function setCompanyName(?string $value): self;

    public function setCountry(?string $value): self;

    public function setEmail(?string $value): self;

    public function setPhone(?string $value): self;

    public function setPostalCode(?string $value): self;

    public function setStateOrProvince(?string $value): self;
}

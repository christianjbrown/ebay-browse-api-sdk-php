<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ItemCharityTermsInterface
{
    public function getCharityOrgId(): ?string;

    public function getDonationPercentage(): ?float;

    public function getLogoImage(): ?ImageInterface;

    public function getName(): ?string;

    public function getWebsite(): ?string;

    public function setCharityOrgId(?string $value): self;

    public function setDonationPercentage(?float $value): self;

    public function setLogoImage(?ImageInterface $value): self;

    public function setName(?string $value): self;

    public function setWebsite(?string $value): self;
}

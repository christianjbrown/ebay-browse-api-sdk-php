<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class ItemCharityTerms implements ItemCharityTermsInterface
{
    private ?string $charityOrgId = null;
    private ?float $donationPercentage = null;
    private ?ImageInterface $logoImage = null;
    private ?string $name = null;
    private ?string $website = null;

    public function getCharityOrgId(): ?string
    {
        return $this->charityOrgId;
    }

    public function getDonationPercentage(): ?float
    {
        return $this->donationPercentage;
    }

    public function getLogoImage(): ?ImageInterface
    {
        return $this->logoImage;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setCharityOrgId(?string $value): ItemCharityTermsInterface
    {
        $this->charityOrgId = $value;

        return $this;
    }

    public function setDonationPercentage(?float $value): ItemCharityTermsInterface
    {
        $this->donationPercentage = $value;

        return $this;
    }

    public function setLogoImage(?ImageInterface $value): ItemCharityTermsInterface
    {
        $this->logoImage = $value;

        return $this;
    }

    public function setName(?string $value): ItemCharityTermsInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setWebsite(?string $value): ItemCharityTermsInterface
    {
        $this->website = $value;

        return $this;
    }
}

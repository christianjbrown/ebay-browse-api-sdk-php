<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class Tax implements TaxInterface
{
    private ?bool $ebayCollectAndRemitTax = null;
    private ?bool $includedInPrice = null;
    private ?bool $shippingAndHandlingTaxed = null;
    private ?TaxJurisdictionInterface $taxJurisdiction = null;
    private ?string $taxPercentage = null;
    private ?string $taxType = null;

    public function getEbayCollectAndRemitTax(): ?bool
    {
        return $this->ebayCollectAndRemitTax;
    }

    public function getIncludedInPrice(): ?bool
    {
        return $this->includedInPrice;
    }

    public function getShippingAndHandlingTaxed(): ?bool
    {
        return $this->shippingAndHandlingTaxed;
    }

    public function getTaxJurisdiction(): ?TaxJurisdictionInterface
    {
        return $this->taxJurisdiction;
    }

    public function getTaxPercentage(): ?string
    {
        return $this->taxPercentage;
    }

    public function getTaxType(): ?string
    {
        return $this->taxType;
    }

    public function setEbayCollectAndRemitTax(?bool $value): TaxInterface
    {
        $this->ebayCollectAndRemitTax = $value;

        return $this;
    }

    public function setIncludedInPrice(?bool $value): TaxInterface
    {
        $this->includedInPrice = $value;

        return $this;
    }

    public function setShippingAndHandlingTaxed(?bool $value): TaxInterface
    {
        $this->shippingAndHandlingTaxed = $value;

        return $this;
    }

    public function setTaxJurisdiction(?TaxJurisdictionInterface $value): TaxInterface
    {
        $this->taxJurisdiction = $value;

        return $this;
    }

    public function setTaxPercentage(?string $value): TaxInterface
    {
        $this->taxPercentage = $value;

        return $this;
    }

    public function setTaxType(?string $value): TaxInterface
    {
        $this->taxType = $value;

        return $this;
    }
}

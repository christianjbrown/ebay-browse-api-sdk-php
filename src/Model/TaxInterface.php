<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface TaxInterface
{
    public function getEbayCollectAndRemitTax(): ?bool;

    public function getIncludedInPrice(): ?bool;

    public function getShippingAndHandlingTaxed(): ?bool;

    public function getTaxJurisdiction(): ?TaxJurisdictionInterface;

    public function getTaxPercentage(): ?string;

    public function getTaxType(): ?string;

    public function setEbayCollectAndRemitTax(?bool $value): self;

    public function setIncludedInPrice(?bool $value): self;

    public function setShippingAndHandlingTaxed(?bool $value): self;

    public function setTaxJurisdiction(?TaxJurisdictionInterface $value): self;

    public function setTaxPercentage(?string $value): self;

    public function setTaxType(?string $value): self;
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class TaxJurisdiction implements TaxJurisdictionInterface
{
    private ?RegionInterface $region = null;
    private ?string $taxJurisdictionId = null;

    public function getRegion(): ?RegionInterface
    {
        return $this->region;
    }

    public function getTaxJurisdictionId(): ?string
    {
        return $this->taxJurisdictionId;
    }

    public function setRegion(?RegionInterface $value): TaxJurisdictionInterface
    {
        $this->region = $value;

        return $this;
    }

    public function setTaxJurisdictionId(?string $value): TaxJurisdictionInterface
    {
        $this->taxJurisdictionId = $value;

        return $this;
    }
}

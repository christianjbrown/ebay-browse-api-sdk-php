<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface TaxJurisdictionInterface
{
    public function getRegion(): ?RegionInterface;

    public function getTaxJurisdictionId(): ?string;

    public function setRegion(?RegionInterface $value): self;

    public function setTaxJurisdictionId(?string $value): self;
}

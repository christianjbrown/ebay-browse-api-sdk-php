<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface RegionInterface
{
    public function getRegionName(): ?string;

    public function getRegionType(): ?string;

    public function setRegionName(?string $value): self;

    public function setRegionType(?string $value): self;
}

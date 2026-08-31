<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ShipToRegionInterface
{
    public function getRegionId(): ?string;

    public function getRegionName(): ?string;

    public function getRegionType(): ?string;

    public function setRegionId(?string $value): self;

    public function setRegionName(?string $value): self;

    public function setRegionType(?string $value): self;
}

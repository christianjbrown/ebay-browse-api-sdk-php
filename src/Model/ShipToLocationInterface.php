<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ShipToLocationInterface
{
    public function getCountry(): ?string;

    public function getPostalCode(): ?string;

    public function setCountry(?string $value): self;

    public function setPostalCode(?string $value): self;
}

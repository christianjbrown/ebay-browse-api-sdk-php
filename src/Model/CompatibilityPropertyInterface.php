<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface CompatibilityPropertyInterface
{
    public function getLocalizedName(): ?string;

    public function getName(): ?string;

    public function getValue(): ?string;

    public function setLocalizedName(?string $value): self;

    public function setName(?string $value): self;

    public function setValue(?string $value): self;
}

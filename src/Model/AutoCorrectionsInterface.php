<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface AutoCorrectionsInterface
{
    public function getQ(): ?string;

    public function setQ(?string $value): self;
}

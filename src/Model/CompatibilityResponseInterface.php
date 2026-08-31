<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface CompatibilityResponseInterface
{
    public function getCompatibilityStatus(): ?string;

    /**
     * @return array<int, ErrorInterface>
     */
    public function getWarnings(): array;

    public function setCompatibilityStatus(?string $value): self;

    /**
     * @param array<int, ErrorInterface> $value
     */
    public function setWarnings(array $value): self;
}

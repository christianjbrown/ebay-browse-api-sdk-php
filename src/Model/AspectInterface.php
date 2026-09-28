<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface AspectInterface
{
    public function getLocalizedName(): ?string;

    /**
     * @return array<int, string>
     */
    public function getLocalizedValues(): array;

    public function setLocalizedName(?string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setLocalizedValues(array $value): self;
}

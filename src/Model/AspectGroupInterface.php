<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface AspectGroupInterface
{
    /**
     * @return array<int, AspectInterface>
     */
    public function getAspects(): array;

    public function getLocalizedGroupName(): ?string;

    /**
     * @param array<int, AspectInterface> $value
     */
    public function setAspects(array $value): self;

    public function setLocalizedGroupName(?string $value): self;
}

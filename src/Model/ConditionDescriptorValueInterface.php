<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ConditionDescriptorValueInterface
{
    /**
     * @return array<int, string>
     */
    public function getAdditionalInfo(): array;

    public function getContent(): ?string;

    /**
     * @param array<int, string> $value
     */
    public function setAdditionalInfo(array $value): self;

    public function setContent(?string $value): self;
}

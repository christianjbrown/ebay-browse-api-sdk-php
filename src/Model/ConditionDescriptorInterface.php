<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ConditionDescriptorInterface
{
    public function getName(): ?string;

    /**
     * @return array<int, ConditionDescriptorValueInterface>
     */
    public function getValues(): array;

    public function setName(?string $value): self;

    /**
     * @param array<int, ConditionDescriptorValueInterface> $value
     */
    public function setValues(array $value): self;
}

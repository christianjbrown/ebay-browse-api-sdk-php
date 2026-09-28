<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class ConditionDescriptor implements ConditionDescriptorInterface
{
    private ?string $name = null;

    /**
     * @var array<int, ConditionDescriptorValueInterface>
     */
    private array $values = [];

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return array<int, ConditionDescriptorValueInterface>
     */
    public function getValues(): array
    {
        return $this->values;
    }

    public function setName(?string $value): ConditionDescriptorInterface
    {
        $this->name = $value;

        return $this;
    }

    /**
     * @param array<int, ConditionDescriptorValueInterface> $value
     */
    public function setValues(array $value): ConditionDescriptorInterface
    {
        $this->values = $value;

        return $this;
    }
}

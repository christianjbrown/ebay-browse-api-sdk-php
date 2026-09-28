<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class CompatibilityProperty implements CompatibilityPropertyInterface
{
    private ?string $localizedName = null;
    private ?string $name = null;
    private ?string $value = null;

    public function getLocalizedName(): ?string
    {
        return $this->localizedName;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setLocalizedName(?string $value): CompatibilityPropertyInterface
    {
        $this->localizedName = $value;

        return $this;
    }

    public function setName(?string $value): CompatibilityPropertyInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setValue(?string $value): CompatibilityPropertyInterface
    {
        $this->value = $value;

        return $this;
    }
}

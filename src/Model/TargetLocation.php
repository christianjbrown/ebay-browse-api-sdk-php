<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class TargetLocation implements TargetLocationInterface
{
    private ?string $unitOfMeasure = null;
    private ?string $value = null;

    public function getUnitOfMeasure(): ?string
    {
        return $this->unitOfMeasure;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setUnitOfMeasure(?string $value): TargetLocationInterface
    {
        $this->unitOfMeasure = $value;

        return $this;
    }

    public function setValue(?string $value): TargetLocationInterface
    {
        $this->value = $value;

        return $this;
    }
}

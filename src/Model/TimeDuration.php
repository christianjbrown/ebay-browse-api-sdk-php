<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class TimeDuration implements TimeDurationInterface
{
    private string $unit;
    private int $value;

    public function __construct(string $unit, int $value)
    {
        $this->unit = $unit;
        $this->value = $value;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setUnit(string $value): TimeDurationInterface
    {
        $this->unit = $value;

        return $this;
    }

    public function setValue(int $value): TimeDurationInterface
    {
        $this->value = $value;

        return $this;
    }
}

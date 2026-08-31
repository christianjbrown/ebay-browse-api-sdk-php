<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface TimeDurationInterface
{
    public function getUnit(): string;

    public function getValue(): int;

    public function setUnit(string $value): self;

    public function setValue(int $value): self;
}

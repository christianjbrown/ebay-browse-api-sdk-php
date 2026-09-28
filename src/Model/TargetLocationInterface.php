<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface TargetLocationInterface
{
    public function getUnitOfMeasure(): ?string;

    public function getValue(): ?string;

    public function setUnitOfMeasure(?string $value): self;

    public function setValue(?string $value): self;
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface TypedNameValueInterface
{
    public function getName(): string;

    public function getType(): ?string;

    public function getValue(): string;

    public function setName(string $value): self;

    public function setType(?string $value): self;

    public function setValue(string $value): self;
}

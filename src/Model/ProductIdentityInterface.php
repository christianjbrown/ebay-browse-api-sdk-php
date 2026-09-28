<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ProductIdentityInterface
{
    public function getIdentifierType(): ?string;

    public function getIdentifierValue(): ?string;

    public function setIdentifierType(?string $value): self;

    public function setIdentifierValue(?string $value): self;
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface SellerCustomPolicyInterface
{
    public function getDescription(): ?string;

    public function getLabel(): ?string;

    public function getType(): ?string;

    public function setDescription(?string $value): self;

    public function setLabel(?string $value): self;

    public function setType(?string $value): self;
}

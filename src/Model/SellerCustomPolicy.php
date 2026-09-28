<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class SellerCustomPolicy implements SellerCustomPolicyInterface
{
    private ?string $description = null;
    private ?string $label = null;
    private ?string $type = null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setDescription(?string $value): SellerCustomPolicyInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setLabel(?string $value): SellerCustomPolicyInterface
    {
        $this->label = $value;

        return $this;
    }

    public function setType(?string $value): SellerCustomPolicyInterface
    {
        $this->type = $value;

        return $this;
    }
}

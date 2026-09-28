<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class ProductIdentity implements ProductIdentityInterface
{
    private ?string $identifierType = null;
    private ?string $identifierValue = null;

    public function getIdentifierType(): ?string
    {
        return $this->identifierType;
    }

    public function getIdentifierValue(): ?string
    {
        return $this->identifierValue;
    }

    public function setIdentifierType(?string $value): ProductIdentityInterface
    {
        $this->identifierType = $value;

        return $this;
    }

    public function setIdentifierValue(?string $value): ProductIdentityInterface
    {
        $this->identifierValue = $value;

        return $this;
    }
}

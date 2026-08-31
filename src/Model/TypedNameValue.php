<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class TypedNameValue implements TypedNameValueInterface
{
    private string $name;
    private ?string $type = null;
    private string $value;

    public function __construct(string $name, string $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setName(string $value): TypedNameValueInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setType(?string $value): TypedNameValueInterface
    {
        $this->type = $value;

        return $this;
    }

    public function setValue(string $value): TypedNameValueInterface
    {
        $this->value = $value;

        return $this;
    }
}

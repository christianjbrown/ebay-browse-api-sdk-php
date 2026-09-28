<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class Aspect implements AspectInterface
{
    private ?string $localizedName = null;

    /**
     * @var array<int, string>
     */
    private array $localizedValues = [];

    public function getLocalizedName(): ?string
    {
        return $this->localizedName;
    }

    /**
     * @return array<int, string>
     */
    public function getLocalizedValues(): array
    {
        return $this->localizedValues;
    }

    public function setLocalizedName(?string $value): AspectInterface
    {
        $this->localizedName = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setLocalizedValues(array $value): AspectInterface
    {
        $this->localizedValues = $value;

        return $this;
    }
}

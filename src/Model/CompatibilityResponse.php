<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class CompatibilityResponse implements CompatibilityResponseInterface
{
    private ?string $compatibilityStatus = null;

    /**
     * @var array<int, ErrorInterface>
     */
    private array $warnings = [];

    public function getCompatibilityStatus(): ?string
    {
        return $this->compatibilityStatus;
    }

    /**
     * @return array<int, ErrorInterface>
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

    public function setCompatibilityStatus(?string $value): CompatibilityResponseInterface
    {
        $this->compatibilityStatus = $value;

        return $this;
    }

    /**
     * @param array<int, ErrorInterface> $value
     */
    public function setWarnings(array $value): CompatibilityResponseInterface
    {
        $this->warnings = $value;

        return $this;
    }
}

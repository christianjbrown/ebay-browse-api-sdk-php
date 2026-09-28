<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class ConditionDescriptorValue implements ConditionDescriptorValueInterface
{
    /**
     * @var array<int, string>
     */
    private array $additionalInfo = [];
    private ?string $content = null;

    /**
     * @return array<int, string>
     */
    public function getAdditionalInfo(): array
    {
        return $this->additionalInfo;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param array<int, string> $value
     */
    public function setAdditionalInfo(array $value): ConditionDescriptorValueInterface
    {
        $this->additionalInfo = $value;

        return $this;
    }

    public function setContent(?string $value): ConditionDescriptorValueInterface
    {
        $this->content = $value;

        return $this;
    }
}

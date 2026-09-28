<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class AspectGroup implements AspectGroupInterface
{
    /**
     * @var array<int, AspectInterface>
     */
    private array $aspects = [];
    private ?string $localizedGroupName = null;

    /**
     * @return array<int, AspectInterface>
     */
    public function getAspects(): array
    {
        return $this->aspects;
    }

    public function getLocalizedGroupName(): ?string
    {
        return $this->localizedGroupName;
    }

    /**
     * @param array<int, AspectInterface> $value
     */
    public function setAspects(array $value): AspectGroupInterface
    {
        $this->aspects = $value;

        return $this;
    }

    public function setLocalizedGroupName(?string $value): AspectGroupInterface
    {
        $this->localizedGroupName = $value;

        return $this;
    }
}

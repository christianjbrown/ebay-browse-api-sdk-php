<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class HazardPictogram implements HazardPictogramInterface
{
    private ?string $pictogramDescription = null;
    private ?string $pictogramId = null;
    private ?string $pictogramUrl = null;

    public function getPictogramDescription(): ?string
    {
        return $this->pictogramDescription;
    }

    public function getPictogramId(): ?string
    {
        return $this->pictogramId;
    }

    public function getPictogramUrl(): ?string
    {
        return $this->pictogramUrl;
    }

    public function setPictogramDescription(?string $value): HazardPictogramInterface
    {
        $this->pictogramDescription = $value;

        return $this;
    }

    public function setPictogramId(?string $value): HazardPictogramInterface
    {
        $this->pictogramId = $value;

        return $this;
    }

    public function setPictogramUrl(?string $value): HazardPictogramInterface
    {
        $this->pictogramUrl = $value;

        return $this;
    }
}

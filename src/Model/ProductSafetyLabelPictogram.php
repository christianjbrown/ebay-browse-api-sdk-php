<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class ProductSafetyLabelPictogram implements ProductSafetyLabelPictogramInterface
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

    public function setPictogramDescription(?string $value): ProductSafetyLabelPictogramInterface
    {
        $this->pictogramDescription = $value;

        return $this;
    }

    public function setPictogramId(?string $value): ProductSafetyLabelPictogramInterface
    {
        $this->pictogramId = $value;

        return $this;
    }

    public function setPictogramUrl(?string $value): ProductSafetyLabelPictogramInterface
    {
        $this->pictogramUrl = $value;

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class Image implements ImageInterface
{
    private ?int $height = null;
    private string $imageUrl;
    private ?int $width = null;

    public function __construct(string $imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setHeight(?int $value): ImageInterface
    {
        $this->height = $value;

        return $this;
    }

    public function setImageUrl(string $value): ImageInterface
    {
        $this->imageUrl = $value;

        return $this;
    }

    public function setWidth(?int $value): ImageInterface
    {
        $this->width = $value;

        return $this;
    }
}

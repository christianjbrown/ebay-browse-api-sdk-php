<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ImageInterface
{
    public function getHeight(): ?int;

    public function getImageUrl(): string;

    public function getWidth(): ?int;

    public function setHeight(?int $value): self;

    public function setImageUrl(string $value): self;

    public function setWidth(?int $value): self;
}

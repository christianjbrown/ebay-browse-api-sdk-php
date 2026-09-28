<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface HazardPictogramInterface
{
    public function getPictogramDescription(): ?string;

    public function getPictogramId(): ?string;

    public function getPictogramUrl(): ?string;

    public function setPictogramDescription(?string $value): self;

    public function setPictogramId(?string $value): self;

    public function setPictogramUrl(?string $value): self;
}

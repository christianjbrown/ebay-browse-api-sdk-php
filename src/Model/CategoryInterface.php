<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface CategoryInterface
{
    public function getCategoryId(): string;

    public function getCategoryName(): ?string;

    public function setCategoryId(string $value): self;

    public function setCategoryName(?string $value): self;
}

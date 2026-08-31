<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface CommonDescriptionInterface
{
    public function getDescription(): ?string;

    /**
     * @return array<int, string>
     */
    public function getItemIds(): array;

    public function setDescription(?string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setItemIds(array $value): self;
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class Category implements CategoryInterface
{
    private string $categoryId;
    private ?string $categoryName = null;

    public function __construct(string $categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryId(string $value): CategoryInterface
    {
        $this->categoryId = $value;

        return $this;
    }

    public function setCategoryName(?string $value): CategoryInterface
    {
        $this->categoryName = $value;

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\CategoryInterface;

interface CategoriesTransformerInterface
{
    public const string ARRAY_NAME = 'category';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, CategoryInterface>
     */
    public function transform(array $data): array;
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ItemsResponseInterface;

interface ItemsResponseTransformerInterface
{
    public const string KEY_ITEMS = 'items';
    public const string KEY_TOTAL = 'total';
    public const string KEY_WARNINGS = 'warnings';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_INTEGER_SPRINTF = '%s not set or not an integer';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ItemsResponseInterface;
}

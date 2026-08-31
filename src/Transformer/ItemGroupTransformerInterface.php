<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ItemGroupInterface;

interface ItemGroupTransformerInterface
{
    public const string KEY_COMMON_DESCRIPTIONS = 'commonDescriptions';
    public const string KEY_ITEMS = 'items';
    public const string KEY_WARNINGS = 'warnings';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ItemGroupInterface;
}

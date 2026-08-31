<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\CommonDescriptionInterface;

interface CommonDescriptionTransformerInterface
{
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_ITEM_IDS = 'itemIds';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CommonDescriptionInterface;
}

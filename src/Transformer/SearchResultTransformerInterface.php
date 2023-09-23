<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindService\Transformer;

interface SearchResultTransformerInterface
{
    public const DATA_KEY_SEARCH_RESULT_ITEM = 'item';

    public function transform(array $data, DatasTransformerInterface $datasTransformer): array;
}

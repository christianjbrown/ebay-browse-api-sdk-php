<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Transformer;

interface DatasTransformerInterface
{
    public function transform(array $data): array;
}

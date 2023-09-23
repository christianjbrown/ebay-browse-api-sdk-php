<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Transformer;

use ChristianBrown\eBay\FindServiceApi\Model\ModelInterface;

interface DataTransformerInterface
{
    public function transform(array $data): ModelInterface;
}

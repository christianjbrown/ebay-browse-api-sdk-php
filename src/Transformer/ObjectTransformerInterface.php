<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Transformer;

use ChristianBrown\eBay\FindServiceApi\Model\ObjectInterface;

interface ObjectTransformerInterface
{
    public function transform(array $data): ObjectInterface;
}

<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindService\Transformer;

use ChristianBrown\eBay\FindService\Model\ModelInterface;

interface DataTransformerInterface
{
    public function transform(array $data): ModelInterface;
}

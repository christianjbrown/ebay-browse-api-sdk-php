<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelPictogramInterface;

interface ProductSafetyLabelPictogramsTransformerInterface
{
    public const string ARRAY_NAME = 'productSafetyLabelPictogram';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, ProductSafetyLabelPictogramInterface>
     */
    public function transform(array $data): array;
}

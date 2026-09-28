<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelsInterface;

interface ProductSafetyLabelsTransformerInterface
{
    public const string KEY_PICTOGRAMS = 'pictograms';
    public const string KEY_STATEMENTS = 'statements';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ProductSafetyLabelsInterface;
}

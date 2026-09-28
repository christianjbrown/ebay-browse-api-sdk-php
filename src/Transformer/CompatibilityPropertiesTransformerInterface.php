<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\CompatibilityPropertyInterface;

interface CompatibilityPropertiesTransformerInterface
{
    public const string ARRAY_NAME = 'compatibilityProperty';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, CompatibilityPropertyInterface>
     */
    public function transform(array $data): array;
}

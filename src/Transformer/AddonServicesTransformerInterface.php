<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\AddonServiceInterface;

interface AddonServicesTransformerInterface
{
    public const string ARRAY_NAME = 'addonService';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, AddonServiceInterface>
     */
    public function transform(array $data): array;
}

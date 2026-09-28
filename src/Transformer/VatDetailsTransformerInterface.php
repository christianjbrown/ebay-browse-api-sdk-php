<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\VatDetailInterface;

interface VatDetailsTransformerInterface
{
    public const string ARRAY_NAME = 'vatDetail';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, VatDetailInterface>
     */
    public function transform(array $data): array;
}

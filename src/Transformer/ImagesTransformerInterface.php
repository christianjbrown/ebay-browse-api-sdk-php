<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ImageInterface;

interface ImagesTransformerInterface
{
    public const string ARRAY_NAME = 'image';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, ImageInterface>
     */
    public function transform(array $data): array;
}

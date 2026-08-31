<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ImageInterface;

interface ImageTransformerInterface
{
    public const string KEY_HEIGHT = 'height';
    public const string KEY_IMAGE_URL = 'imageUrl';
    public const string KEY_WIDTH = 'width';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ImageInterface;
}

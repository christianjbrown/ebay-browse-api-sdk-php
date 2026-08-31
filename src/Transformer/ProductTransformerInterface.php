<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ProductInterface;

interface ProductTransformerInterface
{
    public const string KEY_ADDITIONAL_IMAGES = 'additionalImages';
    public const string KEY_BRAND = 'brand';
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_GTINS = 'gtins';
    public const string KEY_IMAGE = 'image';
    public const string KEY_MPN = 'mpn';
    public const string KEY_TITLE = 'title';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ProductInterface;
}

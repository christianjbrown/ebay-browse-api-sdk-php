<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ProductInterface;

interface ProductTransformerInterface
{
    public const string KEY_ADDITIONAL_IMAGES = 'additionalImages';
    public const string KEY_ADDITIONAL_PRODUCT_IDENTITIES = 'additionalProductIdentities';
    public const string KEY_ASPECT_GROUPS = 'aspectGroups';
    public const string KEY_BRAND = 'brand';
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_GTINS = 'gtins';
    public const string KEY_IMAGE = 'image';
    public const string KEY_MPN = 'mpn';
    public const string KEY_MPNS = 'mpns';
    public const string KEY_TITLE = 'title';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ProductInterface;
}

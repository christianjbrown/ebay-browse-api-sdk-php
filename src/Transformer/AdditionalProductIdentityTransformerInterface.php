<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\AdditionalProductIdentityInterface;

interface AdditionalProductIdentityTransformerInterface
{
    public const string KEY_PRODUCT_IDENTITY = 'productIdentity';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AdditionalProductIdentityInterface;
}

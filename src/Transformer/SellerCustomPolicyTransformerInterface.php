<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\SellerCustomPolicyInterface;

interface SellerCustomPolicyTransformerInterface
{
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_LABEL = 'label';
    public const string KEY_TYPE = 'type';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SellerCustomPolicyInterface;
}

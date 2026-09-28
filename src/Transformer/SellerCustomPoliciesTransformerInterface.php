<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\SellerCustomPolicyInterface;

interface SellerCustomPoliciesTransformerInterface
{
    public const string ARRAY_NAME = 'sellerCustomPolicy';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, SellerCustomPolicyInterface>
     */
    public function transform(array $data): array;
}

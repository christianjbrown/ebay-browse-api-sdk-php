<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\SellerCustomPolicy;
use ChristianBrown\EBay\Browse\Model\SellerCustomPolicyInterface;

use function is_string;

final class SellerCustomPolicyTransformer implements SellerCustomPolicyTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SellerCustomPolicyInterface
    {
        $sellerCustomPolicy = new SellerCustomPolicy();

        self::applyDescription($sellerCustomPolicy, $data);
        self::applyLabel($sellerCustomPolicy, $data);
        self::applyType($sellerCustomPolicy, $data);

        return $sellerCustomPolicy;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(SellerCustomPolicy $sellerCustomPolicy, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $sellerCustomPolicy->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLabel(SellerCustomPolicy $sellerCustomPolicy, array $data): void
    {
        if (empty($data[self::KEY_LABEL])) {
            return;
        }
        if (!is_string($data[self::KEY_LABEL])) {
            return;
        }
        $sellerCustomPolicy->setLabel($data[self::KEY_LABEL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyType(SellerCustomPolicy $sellerCustomPolicy, array $data): void
    {
        if (empty($data[self::KEY_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_TYPE])) {
            return;
        }
        $sellerCustomPolicy->setType($data[self::KEY_TYPE]);
    }
}

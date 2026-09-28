<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ProductIdentity;
use ChristianBrown\EBay\Browse\Model\ProductIdentityInterface;

use function is_string;

final class ProductIdentityTransformer implements ProductIdentityTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ProductIdentityInterface
    {
        $productIdentity = new ProductIdentity();

        self::applyIdentifierType($productIdentity, $data);
        self::applyIdentifierValue($productIdentity, $data);

        return $productIdentity;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIdentifierType(ProductIdentity $productIdentity, array $data): void
    {
        if (empty($data[self::KEY_IDENTIFIER_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_IDENTIFIER_TYPE])) {
            return;
        }
        $productIdentity->setIdentifierType($data[self::KEY_IDENTIFIER_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIdentifierValue(ProductIdentity $productIdentity, array $data): void
    {
        if (empty($data[self::KEY_IDENTIFIER_VALUE])) {
            return;
        }
        if (!is_string($data[self::KEY_IDENTIFIER_VALUE])) {
            return;
        }
        $productIdentity->setIdentifierValue($data[self::KEY_IDENTIFIER_VALUE]);
    }
}

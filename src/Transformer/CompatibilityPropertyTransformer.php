<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\CompatibilityProperty;
use ChristianBrown\EBay\Browse\Model\CompatibilityPropertyInterface;

use function is_string;

final class CompatibilityPropertyTransformer implements CompatibilityPropertyTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CompatibilityPropertyInterface
    {
        $compatibilityProperty = new CompatibilityProperty();

        self::applyLocalizedName($compatibilityProperty, $data);
        self::applyName($compatibilityProperty, $data);
        self::applyValue($compatibilityProperty, $data);

        return $compatibilityProperty;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocalizedName(CompatibilityProperty $compatibilityProperty, array $data): void
    {
        if (empty($data[self::KEY_LOCALIZED_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCALIZED_NAME])) {
            return;
        }
        $compatibilityProperty->setLocalizedName($data[self::KEY_LOCALIZED_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(CompatibilityProperty $compatibilityProperty, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $compatibilityProperty->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(CompatibilityProperty $compatibilityProperty, array $data): void
    {
        if (empty($data[self::KEY_VALUE])) {
            return;
        }
        if (!is_string($data[self::KEY_VALUE])) {
            return;
        }
        $compatibilityProperty->setValue($data[self::KEY_VALUE]);
    }
}

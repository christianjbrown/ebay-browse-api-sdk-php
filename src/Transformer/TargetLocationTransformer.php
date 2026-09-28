<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\TargetLocation;
use ChristianBrown\EBay\Browse\Model\TargetLocationInterface;

use function is_string;

final class TargetLocationTransformer implements TargetLocationTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TargetLocationInterface
    {
        $targetLocation = new TargetLocation();

        self::applyUnitOfMeasure($targetLocation, $data);
        self::applyValue($targetLocation, $data);

        return $targetLocation;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUnitOfMeasure(TargetLocation $targetLocation, array $data): void
    {
        if (empty($data[self::KEY_UNIT_OF_MEASURE])) {
            return;
        }
        if (!is_string($data[self::KEY_UNIT_OF_MEASURE])) {
            return;
        }
        $targetLocation->setUnitOfMeasure($data[self::KEY_UNIT_OF_MEASURE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(TargetLocation $targetLocation, array $data): void
    {
        if (empty($data[self::KEY_VALUE])) {
            return;
        }
        if (!is_string($data[self::KEY_VALUE])) {
            return;
        }
        $targetLocation->setValue($data[self::KEY_VALUE]);
    }
}

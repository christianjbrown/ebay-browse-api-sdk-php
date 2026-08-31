<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\EstimatedAvailability;
use ChristianBrown\EBay\Browse\Model\EstimatedAvailabilityInterface;

use function is_array;
use function is_int;
use function is_string;

final class EstimatedAvailabilityTransformer implements EstimatedAvailabilityTransformerInterface
{
    private StringsTransformerInterface $stringsTransformer;

    public function __construct(StringsTransformerInterface $stringsTransformer)
    {
        $this->stringsTransformer = $stringsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EstimatedAvailabilityInterface
    {
        $estimatedAvailability = new EstimatedAvailability();

        self::applyAvailabilityThreshold($estimatedAvailability, $data);
        self::applyAvailabilityThresholdType($estimatedAvailability, $data);
        $this->applyDeliveryOptions($estimatedAvailability, $data);
        self::applyEstimatedAvailabilityStatus($estimatedAvailability, $data);
        self::applyEstimatedAvailableQuantity($estimatedAvailability, $data);
        self::applyEstimatedRemainingQuantity($estimatedAvailability, $data);
        self::applyEstimatedSoldQuantity($estimatedAvailability, $data);

        return $estimatedAvailability;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAvailabilityThreshold(EstimatedAvailability $estimatedAvailability, array $data): void
    {
        if (!isset($data[self::KEY_AVAILABILITY_THRESHOLD])) {
            return;
        }
        if (!is_int($data[self::KEY_AVAILABILITY_THRESHOLD])) {
            return;
        }
        $estimatedAvailability->setAvailabilityThreshold($data[self::KEY_AVAILABILITY_THRESHOLD]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAvailabilityThresholdType(EstimatedAvailability $estimatedAvailability, array $data): void
    {
        if (empty($data[self::KEY_AVAILABILITY_THRESHOLD_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_AVAILABILITY_THRESHOLD_TYPE])) {
            return;
        }
        $estimatedAvailability->setAvailabilityThresholdType($data[self::KEY_AVAILABILITY_THRESHOLD_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDeliveryOptions(EstimatedAvailability $estimatedAvailability, array $data): void
    {
        if (empty($data[self::KEY_DELIVERY_OPTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_DELIVERY_OPTIONS])) {
            return;
        }
        $estimatedAvailability->setDeliveryOptions($this->stringsTransformer->transform($data[self::KEY_DELIVERY_OPTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEstimatedAvailabilityStatus(EstimatedAvailability $estimatedAvailability, array $data): void
    {
        if (empty($data[self::KEY_ESTIMATED_AVAILABILITY_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_ESTIMATED_AVAILABILITY_STATUS])) {
            return;
        }
        $estimatedAvailability->setEstimatedAvailabilityStatus($data[self::KEY_ESTIMATED_AVAILABILITY_STATUS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEstimatedAvailableQuantity(EstimatedAvailability $estimatedAvailability, array $data): void
    {
        if (!isset($data[self::KEY_ESTIMATED_AVAILABLE_QUANTITY])) {
            return;
        }
        if (!is_int($data[self::KEY_ESTIMATED_AVAILABLE_QUANTITY])) {
            return;
        }
        $estimatedAvailability->setEstimatedAvailableQuantity($data[self::KEY_ESTIMATED_AVAILABLE_QUANTITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEstimatedRemainingQuantity(EstimatedAvailability $estimatedAvailability, array $data): void
    {
        if (!isset($data[self::KEY_ESTIMATED_REMAINING_QUANTITY])) {
            return;
        }
        if (!is_int($data[self::KEY_ESTIMATED_REMAINING_QUANTITY])) {
            return;
        }
        $estimatedAvailability->setEstimatedRemainingQuantity($data[self::KEY_ESTIMATED_REMAINING_QUANTITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEstimatedSoldQuantity(EstimatedAvailability $estimatedAvailability, array $data): void
    {
        if (!isset($data[self::KEY_ESTIMATED_SOLD_QUANTITY])) {
            return;
        }
        if (!is_int($data[self::KEY_ESTIMATED_SOLD_QUANTITY])) {
            return;
        }
        $estimatedAvailability->setEstimatedSoldQuantity($data[self::KEY_ESTIMATED_SOLD_QUANTITY]);
    }
}

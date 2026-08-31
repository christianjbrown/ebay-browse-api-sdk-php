<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\EstimatedAvailabilityInterface;

interface EstimatedAvailabilityTransformerInterface
{
    public const string KEY_AVAILABILITY_THRESHOLD = 'availabilityThreshold';
    public const string KEY_AVAILABILITY_THRESHOLD_TYPE = 'availabilityThresholdType';
    public const string KEY_DELIVERY_OPTIONS = 'deliveryOptions';
    public const string KEY_ESTIMATED_AVAILABILITY_STATUS = 'estimatedAvailabilityStatus';
    public const string KEY_ESTIMATED_AVAILABLE_QUANTITY = 'estimatedAvailableQuantity';
    public const string KEY_ESTIMATED_REMAINING_QUANTITY = 'estimatedRemainingQuantity';
    public const string KEY_ESTIMATED_SOLD_QUANTITY = 'estimatedSoldQuantity';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EstimatedAvailabilityInterface;
}

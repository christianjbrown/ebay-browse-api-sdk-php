<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\EstimatedAvailability;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(EstimatedAvailability::class)]
final class EstimatedAvailabilityTest extends TestCase
{
    public function test(): void
    {
        $estimatedAvailability = new EstimatedAvailability();
        self::assertNull($estimatedAvailability->getAvailabilityThreshold());
        self::assertNull($estimatedAvailability->getAvailabilityThresholdType());
        self::assertSame([], $estimatedAvailability->getDeliveryOptions());
        self::assertNull($estimatedAvailability->getEstimatedAvailabilityStatus());
        self::assertNull($estimatedAvailability->getEstimatedAvailableQuantity());
        self::assertNull($estimatedAvailability->getEstimatedRemainingQuantity());
        self::assertNull($estimatedAvailability->getEstimatedSoldQuantity());

        self::assertSame($estimatedAvailability, $estimatedAvailability->setAvailabilityThreshold(151));
        self::assertSame($estimatedAvailability, $estimatedAvailability->setAvailabilityThresholdType('v_52'));
        self::assertSame($estimatedAvailability, $estimatedAvailability->setDeliveryOptions(['s_53']));
        self::assertSame($estimatedAvailability, $estimatedAvailability->setEstimatedAvailabilityStatus('v_54'));
        self::assertSame($estimatedAvailability, $estimatedAvailability->setEstimatedAvailableQuantity(155));
        self::assertSame($estimatedAvailability, $estimatedAvailability->setEstimatedRemainingQuantity(156));
        self::assertSame($estimatedAvailability, $estimatedAvailability->setEstimatedSoldQuantity(157));

        self::assertSame(151, $estimatedAvailability->getAvailabilityThreshold());
        self::assertSame('v_52', $estimatedAvailability->getAvailabilityThresholdType());
        self::assertSame(['s_53'], $estimatedAvailability->getDeliveryOptions());
        self::assertSame('v_54', $estimatedAvailability->getEstimatedAvailabilityStatus());
        self::assertSame(155, $estimatedAvailability->getEstimatedAvailableQuantity());
        self::assertSame(156, $estimatedAvailability->getEstimatedRemainingQuantity());
        self::assertSame(157, $estimatedAvailability->getEstimatedSoldQuantity());
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\PickupOptionSummary;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PickupOptionSummary::class)]
final class PickupOptionSummaryTest extends TestCase
{
    public function test(): void
    {
        $pickupOptionSummary = new PickupOptionSummary();
        self::assertNull($pickupOptionSummary->getPickupLocationType());

        self::assertSame($pickupOptionSummary, $pickupOptionSummary->setPickupLocationType('val_pickupLocationType'));

        self::assertSame('val_pickupLocationType', $pickupOptionSummary->getPickupLocationType());
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\TargetLocation;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TargetLocation::class)]
final class TargetLocationTest extends TestCase
{
    public function test(): void
    {
        $targetLocation = new TargetLocation();
        self::assertNull($targetLocation->getUnitOfMeasure());
        self::assertNull($targetLocation->getValue());

        self::assertSame($targetLocation, $targetLocation->setUnitOfMeasure('val_unitOfMeasure'));
        self::assertSame($targetLocation, $targetLocation->setValue('val_value'));

        self::assertSame('val_unitOfMeasure', $targetLocation->getUnitOfMeasure());
        self::assertSame('val_value', $targetLocation->getValue());
    }
}

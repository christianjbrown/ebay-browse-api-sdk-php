<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\HazardPictogram;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(HazardPictogram::class)]
final class HazardPictogramTest extends TestCase
{
    public function test(): void
    {
        $hazardPictogram = new HazardPictogram();
        self::assertNull($hazardPictogram->getPictogramDescription());
        self::assertNull($hazardPictogram->getPictogramId());
        self::assertNull($hazardPictogram->getPictogramUrl());

        self::assertSame($hazardPictogram, $hazardPictogram->setPictogramDescription('val_pictogramDescription'));
        self::assertSame($hazardPictogram, $hazardPictogram->setPictogramId('val_pictogramId'));
        self::assertSame($hazardPictogram, $hazardPictogram->setPictogramUrl('val_pictogramUrl'));

        self::assertSame('val_pictogramDescription', $hazardPictogram->getPictogramDescription());
        self::assertSame('val_pictogramId', $hazardPictogram->getPictogramId());
        self::assertSame('val_pictogramUrl', $hazardPictogram->getPictogramUrl());
    }
}

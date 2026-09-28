<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\Aspect;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Aspect::class)]
final class AspectTest extends TestCase
{
    public function test(): void
    {
        $localizedValues = ['s'];

        $aspect = new Aspect();
        self::assertNull($aspect->getLocalizedName());
        self::assertSame([], $aspect->getLocalizedValues());

        self::assertSame($aspect, $aspect->setLocalizedName('val_localizedName'));
        self::assertSame($aspect, $aspect->setLocalizedValues($localizedValues));

        self::assertSame('val_localizedName', $aspect->getLocalizedName());
        self::assertSame($localizedValues, $aspect->getLocalizedValues());
    }
}

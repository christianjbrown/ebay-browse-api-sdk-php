<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\CompatibilityProperty;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CompatibilityProperty::class)]
final class CompatibilityPropertyTest extends TestCase
{
    public function test(): void
    {
        $compatibilityProperty = new CompatibilityProperty();
        self::assertNull($compatibilityProperty->getLocalizedName());
        self::assertNull($compatibilityProperty->getName());
        self::assertNull($compatibilityProperty->getValue());

        self::assertSame($compatibilityProperty, $compatibilityProperty->setLocalizedName('val_localizedName'));
        self::assertSame($compatibilityProperty, $compatibilityProperty->setName('val_name'));
        self::assertSame($compatibilityProperty, $compatibilityProperty->setValue('val_value'));

        self::assertSame('val_localizedName', $compatibilityProperty->getLocalizedName());
        self::assertSame('val_name', $compatibilityProperty->getName());
        self::assertSame('val_value', $compatibilityProperty->getValue());
    }
}

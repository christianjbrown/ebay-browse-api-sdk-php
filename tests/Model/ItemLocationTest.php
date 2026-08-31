<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ItemLocation;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ItemLocation::class)]
final class ItemLocationTest extends TestCase
{
    public function test(): void
    {
        $itemLocation = new ItemLocation('v_0');
        self::assertNull($itemLocation->getAddressLine1());
        self::assertNull($itemLocation->getAddressLine2());
        self::assertNull($itemLocation->getCity());
        self::assertSame('v_0', $itemLocation->getCountry());
        self::assertNull($itemLocation->getCounty());
        self::assertNull($itemLocation->getPostalCode());
        self::assertNull($itemLocation->getStateOrProvince());

        self::assertSame($itemLocation, $itemLocation->setAddressLine1('v_51'));
        self::assertSame($itemLocation, $itemLocation->setAddressLine2('v_52'));
        self::assertSame($itemLocation, $itemLocation->setCity('v_53'));
        self::assertSame($itemLocation, $itemLocation->setCountry('v_54'));
        self::assertSame($itemLocation, $itemLocation->setCounty('v_55'));
        self::assertSame($itemLocation, $itemLocation->setPostalCode('v_56'));
        self::assertSame($itemLocation, $itemLocation->setStateOrProvince('v_57'));

        self::assertSame('v_51', $itemLocation->getAddressLine1());
        self::assertSame('v_52', $itemLocation->getAddressLine2());
        self::assertSame('v_53', $itemLocation->getCity());
        self::assertSame('v_54', $itemLocation->getCountry());
        self::assertSame('v_55', $itemLocation->getCounty());
        self::assertSame('v_56', $itemLocation->getPostalCode());
        self::assertSame('v_57', $itemLocation->getStateOrProvince());
    }
}

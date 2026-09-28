<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\AspectGroup;
use ChristianBrown\EBay\Browse\Model\AspectInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AspectGroup::class)]
final class AspectGroupTest extends TestCase
{
    public function test(): void
    {
        $aspects = [self::createStub(AspectInterface::class)];

        $aspectGroup = new AspectGroup();
        self::assertSame([], $aspectGroup->getAspects());
        self::assertNull($aspectGroup->getLocalizedGroupName());

        self::assertSame($aspectGroup, $aspectGroup->setAspects($aspects));
        self::assertSame($aspectGroup, $aspectGroup->setLocalizedGroupName('val_localizedGroupName'));

        self::assertSame($aspects, $aspectGroup->getAspects());
        self::assertSame('val_localizedGroupName', $aspectGroup->getLocalizedGroupName());
    }
}

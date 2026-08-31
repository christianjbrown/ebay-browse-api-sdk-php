<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\AutoCorrections;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AutoCorrections::class)]
final class AutoCorrectionsTest extends TestCase
{
    public function test(): void
    {
        $autoCorrections = new AutoCorrections();
        self::assertNull($autoCorrections->getQ());

        self::assertSame($autoCorrections, $autoCorrections->setQ('v_51'));

        self::assertSame('v_51', $autoCorrections->getQ());
    }
}

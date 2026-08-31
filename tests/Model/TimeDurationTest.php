<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\TimeDuration;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TimeDuration::class)]
final class TimeDurationTest extends TestCase
{
    public function test(): void
    {
        $timeDuration = new TimeDuration('v_0', 101);
        self::assertSame('v_0', $timeDuration->getUnit());
        self::assertSame(101, $timeDuration->getValue());

        self::assertSame($timeDuration, $timeDuration->setUnit('v_51'));
        self::assertSame($timeDuration, $timeDuration->setValue(152));

        self::assertSame('v_51', $timeDuration->getUnit());
        self::assertSame(152, $timeDuration->getValue());
    }
}

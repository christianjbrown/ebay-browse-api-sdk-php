<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\AspectValueDistribution;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AspectValueDistribution::class)]
final class AspectValueDistributionTest extends TestCase
{
    public function test(): void
    {
        $aspectValueDistribution = new AspectValueDistribution();
        self::assertNull($aspectValueDistribution->getLocalizedAspectValue());
        self::assertNull($aspectValueDistribution->getMatchCount());
        self::assertNull($aspectValueDistribution->getRefinementHref());

        self::assertSame($aspectValueDistribution, $aspectValueDistribution->setLocalizedAspectValue('v_51'));
        self::assertSame($aspectValueDistribution, $aspectValueDistribution->setMatchCount(152));
        self::assertSame($aspectValueDistribution, $aspectValueDistribution->setRefinementHref('v_53'));

        self::assertSame('v_51', $aspectValueDistribution->getLocalizedAspectValue());
        self::assertSame(152, $aspectValueDistribution->getMatchCount());
        self::assertSame('v_53', $aspectValueDistribution->getRefinementHref());
    }
}

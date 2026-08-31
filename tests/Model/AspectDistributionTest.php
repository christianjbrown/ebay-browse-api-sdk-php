<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\AspectDistribution;
use ChristianBrown\EBay\Browse\Model\AspectValueDistributionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AspectDistribution::class)]
final class AspectDistributionTest extends TestCase
{
    public function test(): void
    {
        $aspectValueDistributions = [self::createStub(AspectValueDistributionInterface::class)];

        $aspectDistribution = new AspectDistribution();
        self::assertSame([], $aspectDistribution->getAspectValueDistributions());
        self::assertNull($aspectDistribution->getLocalizedAspectName());

        self::assertSame($aspectDistribution, $aspectDistribution->setAspectValueDistributions($aspectValueDistributions));
        self::assertSame($aspectDistribution, $aspectDistribution->setLocalizedAspectName('v_52'));

        self::assertSame($aspectValueDistributions, $aspectDistribution->getAspectValueDistributions());
        self::assertSame('v_52', $aspectDistribution->getLocalizedAspectName());
    }
}

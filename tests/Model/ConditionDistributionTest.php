<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ConditionDistribution;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConditionDistribution::class)]
final class ConditionDistributionTest extends TestCase
{
    public function test(): void
    {
        $conditionDistribution = new ConditionDistribution();
        self::assertNull($conditionDistribution->getCondition());
        self::assertNull($conditionDistribution->getConditionId());
        self::assertNull($conditionDistribution->getMatchCount());
        self::assertNull($conditionDistribution->getRefinementHref());

        self::assertSame($conditionDistribution, $conditionDistribution->setCondition('v_51'));
        self::assertSame($conditionDistribution, $conditionDistribution->setConditionId('v_52'));
        self::assertSame($conditionDistribution, $conditionDistribution->setMatchCount(153));
        self::assertSame($conditionDistribution, $conditionDistribution->setRefinementHref('v_54'));

        self::assertSame('v_51', $conditionDistribution->getCondition());
        self::assertSame('v_52', $conditionDistribution->getConditionId());
        self::assertSame(153, $conditionDistribution->getMatchCount());
        self::assertSame('v_54', $conditionDistribution->getRefinementHref());
    }
}

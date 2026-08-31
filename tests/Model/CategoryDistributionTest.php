<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\CategoryDistribution;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CategoryDistribution::class)]
final class CategoryDistributionTest extends TestCase
{
    public function test(): void
    {
        $categoryDistribution = new CategoryDistribution();
        self::assertNull($categoryDistribution->getCategoryId());
        self::assertNull($categoryDistribution->getCategoryName());
        self::assertNull($categoryDistribution->getMatchCount());
        self::assertNull($categoryDistribution->getRefinementHref());

        self::assertSame($categoryDistribution, $categoryDistribution->setCategoryId('v_51'));
        self::assertSame($categoryDistribution, $categoryDistribution->setCategoryName('v_52'));
        self::assertSame($categoryDistribution, $categoryDistribution->setMatchCount(153));
        self::assertSame($categoryDistribution, $categoryDistribution->setRefinementHref('v_54'));

        self::assertSame('v_51', $categoryDistribution->getCategoryId());
        self::assertSame('v_52', $categoryDistribution->getCategoryName());
        self::assertSame(153, $categoryDistribution->getMatchCount());
        self::assertSame('v_54', $categoryDistribution->getRefinementHref());
    }
}

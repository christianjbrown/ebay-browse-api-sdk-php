<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\AspectDistributionInterface;
use ChristianBrown\EBay\Browse\Model\BuyingOptionDistributionInterface;
use ChristianBrown\EBay\Browse\Model\CategoryDistributionInterface;
use ChristianBrown\EBay\Browse\Model\ConditionDistributionInterface;
use ChristianBrown\EBay\Browse\Model\Refinement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Refinement::class)]
final class RefinementTest extends TestCase
{
    public function test(): void
    {
        $aspectDistributions = [self::createStub(AspectDistributionInterface::class)];
        $buyingOptionDistributions = [self::createStub(BuyingOptionDistributionInterface::class)];
        $categoryDistributions = [self::createStub(CategoryDistributionInterface::class)];
        $conditionDistributions = [self::createStub(ConditionDistributionInterface::class)];

        $refinement = new Refinement();
        self::assertSame([], $refinement->getAspectDistributions());
        self::assertSame([], $refinement->getBuyingOptionDistributions());
        self::assertSame([], $refinement->getCategoryDistributions());
        self::assertSame([], $refinement->getConditionDistributions());
        self::assertNull($refinement->getDominantCategoryId());

        self::assertSame($refinement, $refinement->setAspectDistributions($aspectDistributions));
        self::assertSame($refinement, $refinement->setBuyingOptionDistributions($buyingOptionDistributions));
        self::assertSame($refinement, $refinement->setCategoryDistributions($categoryDistributions));
        self::assertSame($refinement, $refinement->setConditionDistributions($conditionDistributions));
        self::assertSame($refinement, $refinement->setDominantCategoryId('v_55'));

        self::assertSame($aspectDistributions, $refinement->getAspectDistributions());
        self::assertSame($buyingOptionDistributions, $refinement->getBuyingOptionDistributions());
        self::assertSame($categoryDistributions, $refinement->getCategoryDistributions());
        self::assertSame($conditionDistributions, $refinement->getConditionDistributions());
        self::assertSame('v_55', $refinement->getDominantCategoryId());
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ReturnTerms;
use ChristianBrown\EBay\Browse\Model\TimeDurationInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ReturnTerms::class)]
final class ReturnTermsTest extends TestCase
{
    public function test(): void
    {
        $returnPeriod = self::createStub(TimeDurationInterface::class);

        $returnTerms = new ReturnTerms();
        self::assertNull($returnTerms->getExtendedHolidayReturnsOffered());
        self::assertNull($returnTerms->getRefundMethod());
        self::assertNull($returnTerms->getRestockingFeePercentage());
        self::assertNull($returnTerms->getReturnInstructions());
        self::assertNull($returnTerms->getReturnMethod());
        self::assertNull($returnTerms->getReturnPeriod());
        self::assertNull($returnTerms->getReturnShippingCostPayer());
        self::assertNull($returnTerms->getReturnsAccepted());

        self::assertSame($returnTerms, $returnTerms->setExtendedHolidayReturnsOffered(false));
        self::assertSame($returnTerms, $returnTerms->setRefundMethod('v_52'));
        self::assertSame($returnTerms, $returnTerms->setRestockingFeePercentage('v_53'));
        self::assertSame($returnTerms, $returnTerms->setReturnInstructions('v_54'));
        self::assertSame($returnTerms, $returnTerms->setReturnMethod('v_55'));
        self::assertSame($returnTerms, $returnTerms->setReturnPeriod($returnPeriod));
        self::assertSame($returnTerms, $returnTerms->setReturnShippingCostPayer('v_57'));
        self::assertSame($returnTerms, $returnTerms->setReturnsAccepted(false));

        self::assertFalse($returnTerms->getExtendedHolidayReturnsOffered());
        self::assertSame('v_52', $returnTerms->getRefundMethod());
        self::assertSame('v_53', $returnTerms->getRestockingFeePercentage());
        self::assertSame('v_54', $returnTerms->getReturnInstructions());
        self::assertSame('v_55', $returnTerms->getReturnMethod());
        self::assertSame($returnPeriod, $returnTerms->getReturnPeriod());
        self::assertSame('v_57', $returnTerms->getReturnShippingCostPayer());
        self::assertFalse($returnTerms->getReturnsAccepted());
    }
}

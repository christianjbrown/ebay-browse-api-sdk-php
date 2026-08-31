<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ConvertedAmount;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConvertedAmount::class)]
final class ConvertedAmountTest extends TestCase
{
    public function test(): void
    {
        $convertedAmount = new ConvertedAmount('v_0', 'v_1');
        self::assertNull($convertedAmount->getConvertedFromCurrency());
        self::assertNull($convertedAmount->getConvertedFromValue());
        self::assertSame('v_0', $convertedAmount->getCurrency());
        self::assertSame('v_1', $convertedAmount->getValue());

        self::assertSame($convertedAmount, $convertedAmount->setConvertedFromCurrency('v_51'));
        self::assertSame($convertedAmount, $convertedAmount->setConvertedFromValue('v_52'));
        self::assertSame($convertedAmount, $convertedAmount->setCurrency('v_53'));
        self::assertSame($convertedAmount, $convertedAmount->setValue('v_54'));

        self::assertSame('v_51', $convertedAmount->getConvertedFromCurrency());
        self::assertSame('v_52', $convertedAmount->getConvertedFromValue());
        self::assertSame('v_53', $convertedAmount->getCurrency());
        self::assertSame('v_54', $convertedAmount->getValue());
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\Seller;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Seller::class)]
final class SellerTest extends TestCase
{
    public function test(): void
    {
        $seller = new Seller('v_0');
        self::assertNull($seller->getFeedbackPercentage());
        self::assertNull($seller->getFeedbackScore());
        self::assertNull($seller->getSellerAccountType());
        self::assertSame('v_0', $seller->getUsername());

        self::assertSame($seller, $seller->setFeedbackPercentage('v_51'));
        self::assertSame($seller, $seller->setFeedbackScore(152));
        self::assertSame($seller, $seller->setSellerAccountType('v_53'));
        self::assertSame($seller, $seller->setUsername('v_54'));

        self::assertSame('v_51', $seller->getFeedbackPercentage());
        self::assertSame(152, $seller->getFeedbackScore());
        self::assertSame('v_53', $seller->getSellerAccountType());
        self::assertSame('v_54', $seller->getUsername());
    }
}

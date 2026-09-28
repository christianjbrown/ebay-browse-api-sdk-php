<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\Seller;
use ChristianBrown\EBay\Browse\Model\SellerLegalInfoInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Seller::class)]
final class SellerTest extends TestCase
{
    public function test(): void
    {
        $sellerLegalInfo = self::createStub(SellerLegalInfoInterface::class);

        $seller = new Seller('val_username');
        self::assertSame('val_username', $seller->getUsername());
        self::assertNull($seller->getFeedbackPercentage());
        self::assertNull($seller->getFeedbackScore());
        self::assertNull($seller->getSellerAccountType());
        self::assertNull($seller->getSellerLegalInfo());
        self::assertNull($seller->getUserId());

        self::assertSame($seller, $seller->setFeedbackPercentage('val_feedbackPercentage'));
        self::assertSame($seller, $seller->setFeedbackScore(42));
        self::assertSame($seller, $seller->setSellerAccountType('val_sellerAccountType'));
        self::assertSame($seller, $seller->setSellerLegalInfo($sellerLegalInfo));
        self::assertSame($seller, $seller->setUserId('val_userId'));
        self::assertSame($seller, $seller->setUsername('val_username'));

        self::assertSame('val_feedbackPercentage', $seller->getFeedbackPercentage());
        self::assertSame(42, $seller->getFeedbackScore());
        self::assertSame('val_sellerAccountType', $seller->getSellerAccountType());
        self::assertSame($sellerLegalInfo, $seller->getSellerLegalInfo());
        self::assertSame('val_userId', $seller->getUserId());
        self::assertSame('val_username', $seller->getUsername());
    }
}

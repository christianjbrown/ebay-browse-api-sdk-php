<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\VatDetail;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(VatDetail::class)]
final class VatDetailTest extends TestCase
{
    public function test(): void
    {
        $vatDetail = new VatDetail();
        self::assertNull($vatDetail->getIssuingCountry());
        self::assertNull($vatDetail->getVatId());

        self::assertSame($vatDetail, $vatDetail->setIssuingCountry('val_issuingCountry'));
        self::assertSame($vatDetail, $vatDetail->setVatId('val_vatId'));

        self::assertSame('val_issuingCountry', $vatDetail->getIssuingCountry());
        self::assertSame('val_vatId', $vatDetail->getVatId());
    }
}

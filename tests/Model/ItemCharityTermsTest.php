<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ImageInterface;
use ChristianBrown\EBay\Browse\Model\ItemCharityTerms;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ItemCharityTerms::class)]
final class ItemCharityTermsTest extends TestCase
{
    public function test(): void
    {
        $logoImage = self::createStub(ImageInterface::class);

        $itemCharityTerms = new ItemCharityTerms();
        self::assertNull($itemCharityTerms->getCharityOrgId());
        self::assertNull($itemCharityTerms->getDonationPercentage());
        self::assertNull($itemCharityTerms->getLogoImage());
        self::assertNull($itemCharityTerms->getName());
        self::assertNull($itemCharityTerms->getWebsite());

        self::assertSame($itemCharityTerms, $itemCharityTerms->setCharityOrgId('val_charityOrgId'));
        self::assertSame($itemCharityTerms, $itemCharityTerms->setDonationPercentage(3.5));
        self::assertSame($itemCharityTerms, $itemCharityTerms->setLogoImage($logoImage));
        self::assertSame($itemCharityTerms, $itemCharityTerms->setName('val_name'));
        self::assertSame($itemCharityTerms, $itemCharityTerms->setWebsite('val_website'));

        self::assertSame('val_charityOrgId', $itemCharityTerms->getCharityOrgId());
        self::assertSame(3.5, $itemCharityTerms->getDonationPercentage());
        self::assertSame($logoImage, $itemCharityTerms->getLogoImage());
        self::assertSame('val_name', $itemCharityTerms->getName());
        self::assertSame('val_website', $itemCharityTerms->getWebsite());
    }
}

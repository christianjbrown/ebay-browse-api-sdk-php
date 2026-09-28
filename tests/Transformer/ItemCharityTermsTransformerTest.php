<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ImageInterface;
use ChristianBrown\EBay\Browse\Model\ItemCharityTerms;
use ChristianBrown\EBay\Browse\Model\ItemCharityTermsInterface;
use ChristianBrown\EBay\Browse\Transformer\ImageTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemCharityTermsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemCharityTermsTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ItemCharityTerms::class)]
#[CoversClass(ItemCharityTermsTransformer::class)]
final class ItemCharityTermsTransformerTest extends TestCase
{
    private ?ImageInterface $image = null;

    public function testTransform(): void
    {
        $data = [
            ItemCharityTermsTransformerInterface::KEY_CHARITY_ORG_ID => 'v_1',
            ItemCharityTermsTransformerInterface::KEY_DONATION_PERCENTAGE => 3.5,
            ItemCharityTermsTransformerInterface::KEY_LOGO_IMAGE => ['raw_logoImage'],
            ItemCharityTermsTransformerInterface::KEY_NAME => 'v_2',
            ItemCharityTermsTransformerInterface::KEY_WEBSITE => 'v_3',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getCharityOrgId());
        self::assertSame(3.5, $actual->getDonationPercentage());
        self::assertSame($this->image, $actual->getLogoImage());
        self::assertSame('v_2', $actual->getName());
        self::assertSame('v_3', $actual->getWebsite());
    }

    /**
     * @param array<string, mixed>                     $data
     * @param Closure(ItemCharityTermsInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ItemCharityTermsInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ItemCharityTermsInterface $model): void {
                self::assertNull($model->getCharityOrgId());
                self::assertNull($model->getDonationPercentage());
                self::assertNull($model->getLogoImage());
                self::assertNull($model->getName());
                self::assertNull($model->getWebsite());
            },
        ];

        yield 'charityOrgIdWrongType' => [
            [...$base, ItemCharityTermsTransformerInterface::KEY_CHARITY_ORG_ID => 42],
            static function (ItemCharityTermsInterface $model): void {
                self::assertNull($model->getCharityOrgId());
            },
        ];

        yield 'donationPercentageWrongType' => [
            [...$base, ItemCharityTermsTransformerInterface::KEY_DONATION_PERCENTAGE => 'x'],
            static function (ItemCharityTermsInterface $model): void {
                self::assertNull($model->getDonationPercentage());
            },
        ];

        yield 'donationPercentageIntFallback' => [
            [...$base, ItemCharityTermsTransformerInterface::KEY_DONATION_PERCENTAGE => 4],
            static function (ItemCharityTermsInterface $model): void {
                self::assertSame(4.0, $model->getDonationPercentage());
            },
        ];

        yield 'logoImageWrongType' => [
            [...$base, ItemCharityTermsTransformerInterface::KEY_LOGO_IMAGE => 'x'],
            static function (ItemCharityTermsInterface $model): void {
                self::assertNull($model->getLogoImage());
            },
        ];

        yield 'nameWrongType' => [
            [...$base, ItemCharityTermsTransformerInterface::KEY_NAME => 42],
            static function (ItemCharityTermsInterface $model): void {
                self::assertNull($model->getName());
            },
        ];

        yield 'websiteWrongType' => [
            [...$base, ItemCharityTermsTransformerInterface::KEY_WEBSITE => 42],
            static function (ItemCharityTermsInterface $model): void {
                self::assertNull($model->getWebsite());
            },
        ];
    }

    private function buildTransformer(): ItemCharityTermsTransformer
    {
        $this->image = self::createStub(ImageInterface::class);

        $imageTransformer = self::createStub(ImageTransformerInterface::class);
        $imageTransformer->method('transform')->willReturn($this->image);

        return new ItemCharityTermsTransformer($imageTransformer);
    }
}

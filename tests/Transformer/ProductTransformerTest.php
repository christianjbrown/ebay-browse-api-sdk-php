<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\AdditionalProductIdentityInterface;
use ChristianBrown\EBay\Browse\Model\AspectGroupInterface;
use ChristianBrown\EBay\Browse\Model\ImageInterface;
use ChristianBrown\EBay\Browse\Model\Product;
use ChristianBrown\EBay\Browse\Model\ProductInterface;
use ChristianBrown\EBay\Browse\Transformer\AdditionalProductIdentitiesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\AspectGroupsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ImagesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ImageTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ProductTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Product::class)]
#[CoversClass(ProductTransformer::class)]
final class ProductTransformerTest extends TestCase
{
    private ?AdditionalProductIdentityInterface $additionalProductIdentity = null;
    private ?AspectGroupInterface $aspectGroup = null;
    private ?ImageInterface $image = null;

    public function testTransform(): void
    {
        $data = [
            ProductTransformerInterface::KEY_ADDITIONAL_IMAGES => ['raw_additionalImages'],
            ProductTransformerInterface::KEY_ADDITIONAL_PRODUCT_IDENTITIES => ['raw_additionalProductIdentities'],
            ProductTransformerInterface::KEY_ASPECT_GROUPS => ['raw_aspectGroups'],
            ProductTransformerInterface::KEY_BRAND => 'v_1',
            ProductTransformerInterface::KEY_DESCRIPTION => 'v_2',
            ProductTransformerInterface::KEY_GTINS => ['raw_gtins'],
            ProductTransformerInterface::KEY_IMAGE => ['raw_image'],
            ProductTransformerInterface::KEY_MPN => 'v_3',
            ProductTransformerInterface::KEY_MPNS => ['raw_mpns'],
            ProductTransformerInterface::KEY_TITLE => 'v_4',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame([$this->image], $actual->getAdditionalImages());
        self::assertSame([$this->additionalProductIdentity], $actual->getAdditionalProductIdentities());
        self::assertSame([$this->aspectGroup], $actual->getAspectGroups());
        self::assertSame('v_1', $actual->getBrand());
        self::assertSame('v_2', $actual->getDescription());
        self::assertSame(['s'], $actual->getGtins());
        self::assertSame($this->image, $actual->getImage());
        self::assertSame('v_3', $actual->getMpn());
        self::assertSame(['s'], $actual->getMpns());
        self::assertSame('v_4', $actual->getTitle());
    }

    /**
     * @param array<string, mixed>            $data
     * @param Closure(ProductInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ProductInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ProductInterface $model): void {
                self::assertSame([], $model->getAdditionalImages());
                self::assertSame([], $model->getAdditionalProductIdentities());
                self::assertSame([], $model->getAspectGroups());
                self::assertNull($model->getBrand());
                self::assertNull($model->getDescription());
                self::assertSame([], $model->getGtins());
                self::assertNull($model->getImage());
                self::assertNull($model->getMpn());
                self::assertSame([], $model->getMpns());
                self::assertNull($model->getTitle());
            },
        ];

        yield 'additionalImagesWrongType' => [
            [...$base, ProductTransformerInterface::KEY_ADDITIONAL_IMAGES => 'x'],
            static function (ProductInterface $model): void {
                self::assertSame([], $model->getAdditionalImages());
            },
        ];

        yield 'additionalProductIdentitiesWrongType' => [
            [...$base, ProductTransformerInterface::KEY_ADDITIONAL_PRODUCT_IDENTITIES => 'x'],
            static function (ProductInterface $model): void {
                self::assertSame([], $model->getAdditionalProductIdentities());
            },
        ];

        yield 'aspectGroupsWrongType' => [
            [...$base, ProductTransformerInterface::KEY_ASPECT_GROUPS => 'x'],
            static function (ProductInterface $model): void {
                self::assertSame([], $model->getAspectGroups());
            },
        ];

        yield 'brandWrongType' => [
            [...$base, ProductTransformerInterface::KEY_BRAND => 42],
            static function (ProductInterface $model): void {
                self::assertNull($model->getBrand());
            },
        ];

        yield 'descriptionWrongType' => [
            [...$base, ProductTransformerInterface::KEY_DESCRIPTION => 42],
            static function (ProductInterface $model): void {
                self::assertNull($model->getDescription());
            },
        ];

        yield 'gtinsWrongType' => [
            [...$base, ProductTransformerInterface::KEY_GTINS => 'x'],
            static function (ProductInterface $model): void {
                self::assertSame([], $model->getGtins());
            },
        ];

        yield 'imageWrongType' => [
            [...$base, ProductTransformerInterface::KEY_IMAGE => 'x'],
            static function (ProductInterface $model): void {
                self::assertNull($model->getImage());
            },
        ];

        yield 'mpnWrongType' => [
            [...$base, ProductTransformerInterface::KEY_MPN => 42],
            static function (ProductInterface $model): void {
                self::assertNull($model->getMpn());
            },
        ];

        yield 'mpnsWrongType' => [
            [...$base, ProductTransformerInterface::KEY_MPNS => 'x'],
            static function (ProductInterface $model): void {
                self::assertSame([], $model->getMpns());
            },
        ];

        yield 'titleWrongType' => [
            [...$base, ProductTransformerInterface::KEY_TITLE => 42],
            static function (ProductInterface $model): void {
                self::assertNull($model->getTitle());
            },
        ];
    }

    private function buildTransformer(): ProductTransformer
    {
        $this->image = self::createStub(ImageInterface::class);
        $this->additionalProductIdentity = self::createStub(AdditionalProductIdentityInterface::class);
        $this->aspectGroup = self::createStub(AspectGroupInterface::class);

        $additionalProductIdentitiesTransformer = self::createStub(AdditionalProductIdentitiesTransformerInterface::class);
        $additionalProductIdentitiesTransformer->method('transform')->willReturn([$this->additionalProductIdentity]);
        $aspectGroupsTransformer = self::createStub(AspectGroupsTransformerInterface::class);
        $aspectGroupsTransformer->method('transform')->willReturn([$this->aspectGroup]);
        $imageTransformer = self::createStub(ImageTransformerInterface::class);
        $imageTransformer->method('transform')->willReturn($this->image);
        $imagesTransformer = self::createStub(ImagesTransformerInterface::class);
        $imagesTransformer->method('transform')->willReturn([$this->image]);
        $stringsTransformer = self::createStub(StringsTransformerInterface::class);
        $stringsTransformer->method('transform')->willReturn(['s']);

        return new ProductTransformer($additionalProductIdentitiesTransformer, $aspectGroupsTransformer, $imageTransformer, $imagesTransformer, $stringsTransformer);
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\AdditionalProductIdentityInterface;
use ChristianBrown\EBay\Browse\Model\AspectGroupInterface;
use ChristianBrown\EBay\Browse\Model\ImageInterface;
use ChristianBrown\EBay\Browse\Model\Product;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Product::class)]
final class ProductTest extends TestCase
{
    public function test(): void
    {
        $additionalImages = [self::createStub(ImageInterface::class)];
        $additionalProductIdentities = [self::createStub(AdditionalProductIdentityInterface::class)];
        $aspectGroups = [self::createStub(AspectGroupInterface::class)];
        $gtins = ['s'];
        $image = self::createStub(ImageInterface::class);
        $mpns = ['s'];

        $product = new Product();
        self::assertSame([], $product->getAdditionalImages());
        self::assertSame([], $product->getAdditionalProductIdentities());
        self::assertSame([], $product->getAspectGroups());
        self::assertNull($product->getBrand());
        self::assertNull($product->getDescription());
        self::assertSame([], $product->getGtins());
        self::assertNull($product->getImage());
        self::assertNull($product->getMpn());
        self::assertSame([], $product->getMpns());
        self::assertNull($product->getTitle());

        self::assertSame($product, $product->setAdditionalImages($additionalImages));
        self::assertSame($product, $product->setAdditionalProductIdentities($additionalProductIdentities));
        self::assertSame($product, $product->setAspectGroups($aspectGroups));
        self::assertSame($product, $product->setBrand('val_brand'));
        self::assertSame($product, $product->setDescription('val_description'));
        self::assertSame($product, $product->setGtins($gtins));
        self::assertSame($product, $product->setImage($image));
        self::assertSame($product, $product->setMpn('val_mpn'));
        self::assertSame($product, $product->setMpns($mpns));
        self::assertSame($product, $product->setTitle('val_title'));

        self::assertSame($additionalImages, $product->getAdditionalImages());
        self::assertSame($additionalProductIdentities, $product->getAdditionalProductIdentities());
        self::assertSame($aspectGroups, $product->getAspectGroups());
        self::assertSame('val_brand', $product->getBrand());
        self::assertSame('val_description', $product->getDescription());
        self::assertSame($gtins, $product->getGtins());
        self::assertSame($image, $product->getImage());
        self::assertSame('val_mpn', $product->getMpn());
        self::assertSame($mpns, $product->getMpns());
        self::assertSame('val_title', $product->getTitle());
    }
}

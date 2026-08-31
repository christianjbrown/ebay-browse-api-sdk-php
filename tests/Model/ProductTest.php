<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

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
        $image = self::createStub(ImageInterface::class);

        $product = new Product();
        self::assertSame([], $product->getAdditionalImages());
        self::assertNull($product->getBrand());
        self::assertNull($product->getDescription());
        self::assertSame([], $product->getGtins());
        self::assertNull($product->getImage());
        self::assertNull($product->getMpn());
        self::assertNull($product->getTitle());

        self::assertSame($product, $product->setAdditionalImages($additionalImages));
        self::assertSame($product, $product->setBrand('v_52'));
        self::assertSame($product, $product->setDescription('v_53'));
        self::assertSame($product, $product->setGtins(['s_54']));
        self::assertSame($product, $product->setImage($image));
        self::assertSame($product, $product->setMpn('v_56'));
        self::assertSame($product, $product->setTitle('v_57'));

        self::assertSame($additionalImages, $product->getAdditionalImages());
        self::assertSame('v_52', $product->getBrand());
        self::assertSame('v_53', $product->getDescription());
        self::assertSame(['s_54'], $product->getGtins());
        self::assertSame($image, $product->getImage());
        self::assertSame('v_56', $product->getMpn());
        self::assertSame('v_57', $product->getTitle());
    }
}

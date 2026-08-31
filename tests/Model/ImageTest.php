<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\Image;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Image::class)]
final class ImageTest extends TestCase
{
    public function test(): void
    {
        $image = new Image('v_0');
        self::assertNull($image->getHeight());
        self::assertSame('v_0', $image->getImageUrl());
        self::assertNull($image->getWidth());

        self::assertSame($image, $image->setHeight(151));
        self::assertSame($image, $image->setImageUrl('v_52'));
        self::assertSame($image, $image->setWidth(153));

        self::assertSame(151, $image->getHeight());
        self::assertSame('v_52', $image->getImageUrl());
        self::assertSame(153, $image->getWidth());
    }
}

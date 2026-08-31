<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\Category;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Category::class)]
final class CategoryTest extends TestCase
{
    public function test(): void
    {
        $category = new Category('v_0');
        self::assertSame('v_0', $category->getCategoryId());
        self::assertNull($category->getCategoryName());

        self::assertSame($category, $category->setCategoryId('v_51'));
        self::assertSame($category, $category->setCategoryName('v_52'));

        self::assertSame('v_51', $category->getCategoryId());
        self::assertSame('v_52', $category->getCategoryName());
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Tests\Model;

use ChristianBrown\eBay\FindServiceApi\Model\Pagination;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Pagination::class)]
final class PaginationTest extends TestCase
{
    public function test(): void
    {
        $pagination = new Pagination(42, 3, 25, 10);
        self::assertSame(42, $pagination->getTotalEntries());
        self::assertSame(3, $pagination->getPageNumber());
        self::assertSame(25, $pagination->getEntriesPerPage());
        self::assertSame(10, $pagination->getTotalPages());
    }
}

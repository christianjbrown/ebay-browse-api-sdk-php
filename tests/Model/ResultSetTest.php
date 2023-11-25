<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Tests\Model;

use ChristianBrown\eBay\FindServiceApi\Model\PaginationInterface;
use ChristianBrown\eBay\FindServiceApi\Model\ResultSet;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(ResultSet::class)]
final class ResultSetTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test(): void
    {
        $pagination = $this->createMock(PaginationInterface::class);
        $resultSet = new ResultSet($pagination, ['test-object-1', 'test-object-2']);
        self::assertSame($pagination, $resultSet->getPagination());
        self::assertSame(['test-object-1', 'test-object-2'], $resultSet->getObjects());
    }
}

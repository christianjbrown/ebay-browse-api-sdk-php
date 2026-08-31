<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Exception;

use ChristianBrown\EBay\Browse\Exception\ExceptionInterface;
use ChristianBrown\EBay\Browse\Exception\ItemNotFoundException;
use ChristianBrown\EBay\Browse\Exception\ItemNotFoundExceptionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use RuntimeException;

#[CoversClass(ItemNotFoundException::class)]
final class ItemNotFoundExceptionTest extends TestCase
{
    public function test(): void
    {
        $exception = new ItemNotFoundException('test-message');

        self::assertInstanceOf(ItemNotFoundExceptionInterface::class, $exception);
        self::assertInstanceOf(ExceptionInterface::class, $exception);
        self::assertInstanceOf(RuntimeException::class, $exception);
        self::assertSame('test-message', $exception->getMessage());
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ErrorParameter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ErrorParameter::class)]
final class ErrorParameterTest extends TestCase
{
    public function test(): void
    {
        $errorParameter = new ErrorParameter();
        self::assertNull($errorParameter->getName());
        self::assertNull($errorParameter->getValue());

        self::assertSame($errorParameter, $errorParameter->setName('v_51'));
        self::assertSame($errorParameter, $errorParameter->setValue('v_52'));

        self::assertSame('v_51', $errorParameter->getName());
        self::assertSame('v_52', $errorParameter->getValue());
    }
}

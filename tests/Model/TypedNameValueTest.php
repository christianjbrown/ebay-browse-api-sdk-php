<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\TypedNameValue;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TypedNameValue::class)]
final class TypedNameValueTest extends TestCase
{
    public function test(): void
    {
        $typedNameValue = new TypedNameValue('v_0', 'v_1');
        self::assertSame('v_0', $typedNameValue->getName());
        self::assertNull($typedNameValue->getType());
        self::assertSame('v_1', $typedNameValue->getValue());

        self::assertSame($typedNameValue, $typedNameValue->setName('v_51'));
        self::assertSame($typedNameValue, $typedNameValue->setType('v_52'));
        self::assertSame($typedNameValue, $typedNameValue->setValue('v_53'));

        self::assertSame('v_51', $typedNameValue->getName());
        self::assertSame('v_52', $typedNameValue->getType());
        self::assertSame('v_53', $typedNameValue->getValue());
    }
}

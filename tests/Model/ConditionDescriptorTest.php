<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ConditionDescriptor;
use ChristianBrown\EBay\Browse\Model\ConditionDescriptorValueInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConditionDescriptor::class)]
final class ConditionDescriptorTest extends TestCase
{
    public function test(): void
    {
        $values = [self::createStub(ConditionDescriptorValueInterface::class)];

        $conditionDescriptor = new ConditionDescriptor();
        self::assertNull($conditionDescriptor->getName());
        self::assertSame([], $conditionDescriptor->getValues());

        self::assertSame($conditionDescriptor, $conditionDescriptor->setName('val_name'));
        self::assertSame($conditionDescriptor, $conditionDescriptor->setValues($values));

        self::assertSame('val_name', $conditionDescriptor->getName());
        self::assertSame($values, $conditionDescriptor->getValues());
    }
}

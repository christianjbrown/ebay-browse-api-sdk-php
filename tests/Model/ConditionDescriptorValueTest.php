<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ConditionDescriptorValue;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConditionDescriptorValue::class)]
final class ConditionDescriptorValueTest extends TestCase
{
    public function test(): void
    {
        $additionalInfo = ['s'];

        $conditionDescriptorValue = new ConditionDescriptorValue();
        self::assertSame([], $conditionDescriptorValue->getAdditionalInfo());
        self::assertNull($conditionDescriptorValue->getContent());

        self::assertSame($conditionDescriptorValue, $conditionDescriptorValue->setAdditionalInfo($additionalInfo));
        self::assertSame($conditionDescriptorValue, $conditionDescriptorValue->setContent('val_content'));

        self::assertSame($additionalInfo, $conditionDescriptorValue->getAdditionalInfo());
        self::assertSame('val_content', $conditionDescriptorValue->getContent());
    }
}

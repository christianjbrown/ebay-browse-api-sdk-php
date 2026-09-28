<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ConditionDescriptorValueInterface;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorValuesTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorValuesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorValueTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ConditionDescriptorValuesTransformer::class)]
final class ConditionDescriptorValuesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(ConditionDescriptorValueInterface::class);
        $second = self::createStub(ConditionDescriptorValueInterface::class);

        $conditionDescriptorValueTransformer = self::createStub(ConditionDescriptorValueTransformerInterface::class);
        $conditionDescriptorValueTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new ConditionDescriptorValuesTransformer($conditionDescriptorValueTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $conditionDescriptorValueTransformer = self::createStub(ConditionDescriptorValueTransformerInterface::class);

        $transformer = new ConditionDescriptorValuesTransformer($conditionDescriptorValueTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(ConditionDescriptorValueInterface::class);

        $conditionDescriptorValueTransformer = self::createMock(ConditionDescriptorValueTransformerInterface::class);
        $conditionDescriptorValueTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new ConditionDescriptorValuesTransformer($conditionDescriptorValueTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $conditionDescriptorValueTransformer = self::createStub(ConditionDescriptorValueTransformerInterface::class);

        $transformer = new ConditionDescriptorValuesTransformer($conditionDescriptorValueTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ConditionDescriptorValuesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ConditionDescriptorValuesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ConditionDescriptorInterface;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ConditionDescriptorsTransformer::class)]
final class ConditionDescriptorsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(ConditionDescriptorInterface::class);
        $second = self::createStub(ConditionDescriptorInterface::class);

        $conditionDescriptorTransformer = self::createStub(ConditionDescriptorTransformerInterface::class);
        $conditionDescriptorTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new ConditionDescriptorsTransformer($conditionDescriptorTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $conditionDescriptorTransformer = self::createStub(ConditionDescriptorTransformerInterface::class);

        $transformer = new ConditionDescriptorsTransformer($conditionDescriptorTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(ConditionDescriptorInterface::class);

        $conditionDescriptorTransformer = self::createMock(ConditionDescriptorTransformerInterface::class);
        $conditionDescriptorTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new ConditionDescriptorsTransformer($conditionDescriptorTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $conditionDescriptorTransformer = self::createStub(ConditionDescriptorTransformerInterface::class);

        $transformer = new ConditionDescriptorsTransformer($conditionDescriptorTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ConditionDescriptorsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ConditionDescriptorsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

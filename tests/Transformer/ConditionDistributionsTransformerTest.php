<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ConditionDistributionInterface;
use ChristianBrown\EBay\Browse\Transformer\ConditionDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDistributionsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ConditionDistributionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ConditionDistributionsTransformer::class)]
final class ConditionDistributionsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(ConditionDistributionInterface::class);
        $second = self::createStub(ConditionDistributionInterface::class);

        $conditionDistributionTransformer = self::createStub(ConditionDistributionTransformerInterface::class);
        $conditionDistributionTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new ConditionDistributionsTransformer($conditionDistributionTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $conditionDistributionTransformer = self::createStub(ConditionDistributionTransformerInterface::class);

        $transformer = new ConditionDistributionsTransformer($conditionDistributionTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(ConditionDistributionInterface::class);

        $conditionDistributionTransformer = self::createMock(ConditionDistributionTransformerInterface::class);
        $conditionDistributionTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new ConditionDistributionsTransformer($conditionDistributionTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $conditionDistributionTransformer = self::createStub(ConditionDistributionTransformerInterface::class);

        $transformer = new ConditionDistributionsTransformer($conditionDistributionTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ConditionDistributionsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ConditionDistributionsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

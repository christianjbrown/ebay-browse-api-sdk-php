<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\AspectValueDistributionInterface;
use ChristianBrown\EBay\Browse\Transformer\AspectValueDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectValueDistributionsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\AspectValueDistributionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(AspectValueDistributionsTransformer::class)]
final class AspectValueDistributionsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(AspectValueDistributionInterface::class);
        $second = self::createStub(AspectValueDistributionInterface::class);

        $aspectValueDistributionTransformer = self::createStub(AspectValueDistributionTransformerInterface::class);
        $aspectValueDistributionTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new AspectValueDistributionsTransformer($aspectValueDistributionTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $aspectValueDistributionTransformer = self::createStub(AspectValueDistributionTransformerInterface::class);

        $transformer = new AspectValueDistributionsTransformer($aspectValueDistributionTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(AspectValueDistributionInterface::class);

        $aspectValueDistributionTransformer = self::createMock(AspectValueDistributionTransformerInterface::class);
        $aspectValueDistributionTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new AspectValueDistributionsTransformer($aspectValueDistributionTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $aspectValueDistributionTransformer = self::createStub(AspectValueDistributionTransformerInterface::class);

        $transformer = new AspectValueDistributionsTransformer($aspectValueDistributionTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(AspectValueDistributionsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, AspectValueDistributionsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

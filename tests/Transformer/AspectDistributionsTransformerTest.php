<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\AspectDistributionInterface;
use ChristianBrown\EBay\Browse\Transformer\AspectDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectDistributionsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\AspectDistributionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(AspectDistributionsTransformer::class)]
final class AspectDistributionsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(AspectDistributionInterface::class);
        $second = self::createStub(AspectDistributionInterface::class);

        $aspectDistributionTransformer = self::createStub(AspectDistributionTransformerInterface::class);
        $aspectDistributionTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new AspectDistributionsTransformer($aspectDistributionTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $aspectDistributionTransformer = self::createStub(AspectDistributionTransformerInterface::class);

        $transformer = new AspectDistributionsTransformer($aspectDistributionTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(AspectDistributionInterface::class);

        $aspectDistributionTransformer = self::createMock(AspectDistributionTransformerInterface::class);
        $aspectDistributionTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new AspectDistributionsTransformer($aspectDistributionTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $aspectDistributionTransformer = self::createStub(AspectDistributionTransformerInterface::class);

        $transformer = new AspectDistributionsTransformer($aspectDistributionTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(AspectDistributionsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, AspectDistributionsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

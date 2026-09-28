<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\AspectGroupInterface;
use ChristianBrown\EBay\Browse\Transformer\AspectGroupsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectGroupsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\AspectGroupTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(AspectGroupsTransformer::class)]
final class AspectGroupsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(AspectGroupInterface::class);
        $second = self::createStub(AspectGroupInterface::class);

        $aspectGroupTransformer = self::createStub(AspectGroupTransformerInterface::class);
        $aspectGroupTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new AspectGroupsTransformer($aspectGroupTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $aspectGroupTransformer = self::createStub(AspectGroupTransformerInterface::class);

        $transformer = new AspectGroupsTransformer($aspectGroupTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(AspectGroupInterface::class);

        $aspectGroupTransformer = self::createMock(AspectGroupTransformerInterface::class);
        $aspectGroupTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new AspectGroupsTransformer($aspectGroupTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $aspectGroupTransformer = self::createStub(AspectGroupTransformerInterface::class);

        $transformer = new AspectGroupsTransformer($aspectGroupTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(AspectGroupsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, AspectGroupsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

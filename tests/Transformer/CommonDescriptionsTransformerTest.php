<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\CommonDescriptionInterface;
use ChristianBrown\EBay\Browse\Transformer\CommonDescriptionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\CommonDescriptionsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\CommonDescriptionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(CommonDescriptionsTransformer::class)]
final class CommonDescriptionsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(CommonDescriptionInterface::class);
        $second = self::createStub(CommonDescriptionInterface::class);

        $commonDescriptionTransformer = self::createStub(CommonDescriptionTransformerInterface::class);
        $commonDescriptionTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new CommonDescriptionsTransformer($commonDescriptionTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $commonDescriptionTransformer = self::createStub(CommonDescriptionTransformerInterface::class);

        $transformer = new CommonDescriptionsTransformer($commonDescriptionTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(CommonDescriptionInterface::class);

        $commonDescriptionTransformer = self::createMock(CommonDescriptionTransformerInterface::class);
        $commonDescriptionTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new CommonDescriptionsTransformer($commonDescriptionTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $commonDescriptionTransformer = self::createStub(CommonDescriptionTransformerInterface::class);

        $transformer = new CommonDescriptionsTransformer($commonDescriptionTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CommonDescriptionsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, CommonDescriptionsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

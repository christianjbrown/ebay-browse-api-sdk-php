<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\CompatibilityPropertyInterface;
use ChristianBrown\EBay\Browse\Transformer\CompatibilityPropertiesTransformer;
use ChristianBrown\EBay\Browse\Transformer\CompatibilityPropertiesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\CompatibilityPropertyTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(CompatibilityPropertiesTransformer::class)]
final class CompatibilityPropertiesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(CompatibilityPropertyInterface::class);
        $second = self::createStub(CompatibilityPropertyInterface::class);

        $compatibilityPropertyTransformer = self::createStub(CompatibilityPropertyTransformerInterface::class);
        $compatibilityPropertyTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new CompatibilityPropertiesTransformer($compatibilityPropertyTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $compatibilityPropertyTransformer = self::createStub(CompatibilityPropertyTransformerInterface::class);

        $transformer = new CompatibilityPropertiesTransformer($compatibilityPropertyTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(CompatibilityPropertyInterface::class);

        $compatibilityPropertyTransformer = self::createMock(CompatibilityPropertyTransformerInterface::class);
        $compatibilityPropertyTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new CompatibilityPropertiesTransformer($compatibilityPropertyTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $compatibilityPropertyTransformer = self::createStub(CompatibilityPropertyTransformerInterface::class);

        $transformer = new CompatibilityPropertiesTransformer($compatibilityPropertyTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CompatibilityPropertiesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, CompatibilityPropertiesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

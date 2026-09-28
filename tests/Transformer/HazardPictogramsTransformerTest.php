<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\HazardPictogramInterface;
use ChristianBrown\EBay\Browse\Transformer\HazardPictogramsTransformer;
use ChristianBrown\EBay\Browse\Transformer\HazardPictogramsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\HazardPictogramTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(HazardPictogramsTransformer::class)]
final class HazardPictogramsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(HazardPictogramInterface::class);
        $second = self::createStub(HazardPictogramInterface::class);

        $hazardPictogramTransformer = self::createStub(HazardPictogramTransformerInterface::class);
        $hazardPictogramTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new HazardPictogramsTransformer($hazardPictogramTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $hazardPictogramTransformer = self::createStub(HazardPictogramTransformerInterface::class);

        $transformer = new HazardPictogramsTransformer($hazardPictogramTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(HazardPictogramInterface::class);

        $hazardPictogramTransformer = self::createMock(HazardPictogramTransformerInterface::class);
        $hazardPictogramTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new HazardPictogramsTransformer($hazardPictogramTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $hazardPictogramTransformer = self::createStub(HazardPictogramTransformerInterface::class);

        $transformer = new HazardPictogramsTransformer($hazardPictogramTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(HazardPictogramsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, HazardPictogramsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

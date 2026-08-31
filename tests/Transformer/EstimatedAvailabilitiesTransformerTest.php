<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\EstimatedAvailabilityInterface;
use ChristianBrown\EBay\Browse\Transformer\EstimatedAvailabilitiesTransformer;
use ChristianBrown\EBay\Browse\Transformer\EstimatedAvailabilitiesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\EstimatedAvailabilityTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(EstimatedAvailabilitiesTransformer::class)]
final class EstimatedAvailabilitiesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(EstimatedAvailabilityInterface::class);
        $second = self::createStub(EstimatedAvailabilityInterface::class);

        $estimatedAvailabilityTransformer = self::createStub(EstimatedAvailabilityTransformerInterface::class);
        $estimatedAvailabilityTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new EstimatedAvailabilitiesTransformer($estimatedAvailabilityTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $estimatedAvailabilityTransformer = self::createStub(EstimatedAvailabilityTransformerInterface::class);

        $transformer = new EstimatedAvailabilitiesTransformer($estimatedAvailabilityTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(EstimatedAvailabilityInterface::class);

        $estimatedAvailabilityTransformer = self::createMock(EstimatedAvailabilityTransformerInterface::class);
        $estimatedAvailabilityTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new EstimatedAvailabilitiesTransformer($estimatedAvailabilityTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $estimatedAvailabilityTransformer = self::createStub(EstimatedAvailabilityTransformerInterface::class);

        $transformer = new EstimatedAvailabilitiesTransformer($estimatedAvailabilityTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(EstimatedAvailabilitiesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, EstimatedAvailabilitiesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

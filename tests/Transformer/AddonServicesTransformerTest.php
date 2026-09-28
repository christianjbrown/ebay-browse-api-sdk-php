<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\AddonServiceInterface;
use ChristianBrown\EBay\Browse\Transformer\AddonServicesTransformer;
use ChristianBrown\EBay\Browse\Transformer\AddonServicesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\AddonServiceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(AddonServicesTransformer::class)]
final class AddonServicesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(AddonServiceInterface::class);
        $second = self::createStub(AddonServiceInterface::class);

        $addonServiceTransformer = self::createStub(AddonServiceTransformerInterface::class);
        $addonServiceTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new AddonServicesTransformer($addonServiceTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $addonServiceTransformer = self::createStub(AddonServiceTransformerInterface::class);

        $transformer = new AddonServicesTransformer($addonServiceTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(AddonServiceInterface::class);

        $addonServiceTransformer = self::createMock(AddonServiceTransformerInterface::class);
        $addonServiceTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new AddonServicesTransformer($addonServiceTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $addonServiceTransformer = self::createStub(AddonServiceTransformerInterface::class);

        $transformer = new AddonServicesTransformer($addonServiceTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(AddonServicesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, AddonServicesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

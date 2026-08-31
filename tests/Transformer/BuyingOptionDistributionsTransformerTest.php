<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\BuyingOptionDistributionInterface;
use ChristianBrown\EBay\Browse\Transformer\BuyingOptionDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\BuyingOptionDistributionsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\BuyingOptionDistributionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(BuyingOptionDistributionsTransformer::class)]
final class BuyingOptionDistributionsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(BuyingOptionDistributionInterface::class);
        $second = self::createStub(BuyingOptionDistributionInterface::class);

        $buyingOptionDistributionTransformer = self::createStub(BuyingOptionDistributionTransformerInterface::class);
        $buyingOptionDistributionTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new BuyingOptionDistributionsTransformer($buyingOptionDistributionTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $buyingOptionDistributionTransformer = self::createStub(BuyingOptionDistributionTransformerInterface::class);

        $transformer = new BuyingOptionDistributionsTransformer($buyingOptionDistributionTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(BuyingOptionDistributionInterface::class);

        $buyingOptionDistributionTransformer = self::createMock(BuyingOptionDistributionTransformerInterface::class);
        $buyingOptionDistributionTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new BuyingOptionDistributionsTransformer($buyingOptionDistributionTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $buyingOptionDistributionTransformer = self::createStub(BuyingOptionDistributionTransformerInterface::class);

        $transformer = new BuyingOptionDistributionsTransformer($buyingOptionDistributionTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(BuyingOptionDistributionsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, BuyingOptionDistributionsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

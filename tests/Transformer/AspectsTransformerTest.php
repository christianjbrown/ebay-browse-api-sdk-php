<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\AspectInterface;
use ChristianBrown\EBay\Browse\Transformer\AspectsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\AspectTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(AspectsTransformer::class)]
final class AspectsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(AspectInterface::class);
        $second = self::createStub(AspectInterface::class);

        $aspectTransformer = self::createStub(AspectTransformerInterface::class);
        $aspectTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new AspectsTransformer($aspectTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $aspectTransformer = self::createStub(AspectTransformerInterface::class);

        $transformer = new AspectsTransformer($aspectTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(AspectInterface::class);

        $aspectTransformer = self::createMock(AspectTransformerInterface::class);
        $aspectTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new AspectsTransformer($aspectTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $aspectTransformer = self::createStub(AspectTransformerInterface::class);

        $transformer = new AspectsTransformer($aspectTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(AspectsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, AspectsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

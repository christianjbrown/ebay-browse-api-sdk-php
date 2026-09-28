<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ResponsiblePersonInterface;
use ChristianBrown\EBay\Browse\Transformer\ResponsiblePersonsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ResponsiblePersonsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ResponsiblePersonTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ResponsiblePersonsTransformer::class)]
final class ResponsiblePersonsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(ResponsiblePersonInterface::class);
        $second = self::createStub(ResponsiblePersonInterface::class);

        $responsiblePersonTransformer = self::createStub(ResponsiblePersonTransformerInterface::class);
        $responsiblePersonTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new ResponsiblePersonsTransformer($responsiblePersonTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $responsiblePersonTransformer = self::createStub(ResponsiblePersonTransformerInterface::class);

        $transformer = new ResponsiblePersonsTransformer($responsiblePersonTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(ResponsiblePersonInterface::class);

        $responsiblePersonTransformer = self::createMock(ResponsiblePersonTransformerInterface::class);
        $responsiblePersonTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new ResponsiblePersonsTransformer($responsiblePersonTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $responsiblePersonTransformer = self::createStub(ResponsiblePersonTransformerInterface::class);

        $transformer = new ResponsiblePersonsTransformer($responsiblePersonTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ResponsiblePersonsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ResponsiblePersonsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

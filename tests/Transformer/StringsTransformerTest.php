<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformer;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(StringsTransformer::class)]
final class StringsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $transformer = new StringsTransformer();

        self::assertSame(['FIXED_PRICE', 'AUCTION'], $transformer->transform(['FIXED_PRICE', 'AUCTION']));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new StringsTransformer();

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $transformer = new StringsTransformer();

        self::assertSame(['SHIP_TO_HOME'], $transformer->transform(['SHIP_TO_HOME']));
    }

    public function testTransformThrowsOnFirstNonStringElement(): void
    {
        $transformer = new StringsTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(StringsTransformerInterface::UNEXPECTED_STRING_SPRINTF, StringsTransformerInterface::ARRAY_NAME));

        $transformer->transform([42]);
    }

    public function testTransformThrowsOnLaterNonStringElement(): void
    {
        $transformer = new StringsTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(StringsTransformerInterface::UNEXPECTED_STRING_SPRINTF, StringsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['FIXED_PRICE', 42]);
    }
}

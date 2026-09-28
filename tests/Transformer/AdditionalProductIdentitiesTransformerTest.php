<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\AdditionalProductIdentityInterface;
use ChristianBrown\EBay\Browse\Transformer\AdditionalProductIdentitiesTransformer;
use ChristianBrown\EBay\Browse\Transformer\AdditionalProductIdentitiesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\AdditionalProductIdentityTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(AdditionalProductIdentitiesTransformer::class)]
final class AdditionalProductIdentitiesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(AdditionalProductIdentityInterface::class);
        $second = self::createStub(AdditionalProductIdentityInterface::class);

        $additionalProductIdentityTransformer = self::createStub(AdditionalProductIdentityTransformerInterface::class);
        $additionalProductIdentityTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new AdditionalProductIdentitiesTransformer($additionalProductIdentityTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $additionalProductIdentityTransformer = self::createStub(AdditionalProductIdentityTransformerInterface::class);

        $transformer = new AdditionalProductIdentitiesTransformer($additionalProductIdentityTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(AdditionalProductIdentityInterface::class);

        $additionalProductIdentityTransformer = self::createMock(AdditionalProductIdentityTransformerInterface::class);
        $additionalProductIdentityTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new AdditionalProductIdentitiesTransformer($additionalProductIdentityTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $additionalProductIdentityTransformer = self::createStub(AdditionalProductIdentityTransformerInterface::class);

        $transformer = new AdditionalProductIdentitiesTransformer($additionalProductIdentityTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(AdditionalProductIdentitiesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, AdditionalProductIdentitiesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\SellerCustomPolicyInterface;
use ChristianBrown\EBay\Browse\Transformer\SellerCustomPoliciesTransformer;
use ChristianBrown\EBay\Browse\Transformer\SellerCustomPoliciesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\SellerCustomPolicyTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(SellerCustomPoliciesTransformer::class)]
final class SellerCustomPoliciesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(SellerCustomPolicyInterface::class);
        $second = self::createStub(SellerCustomPolicyInterface::class);

        $sellerCustomPolicyTransformer = self::createStub(SellerCustomPolicyTransformerInterface::class);
        $sellerCustomPolicyTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new SellerCustomPoliciesTransformer($sellerCustomPolicyTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $sellerCustomPolicyTransformer = self::createStub(SellerCustomPolicyTransformerInterface::class);

        $transformer = new SellerCustomPoliciesTransformer($sellerCustomPolicyTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(SellerCustomPolicyInterface::class);

        $sellerCustomPolicyTransformer = self::createMock(SellerCustomPolicyTransformerInterface::class);
        $sellerCustomPolicyTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new SellerCustomPoliciesTransformer($sellerCustomPolicyTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $sellerCustomPolicyTransformer = self::createStub(SellerCustomPolicyTransformerInterface::class);

        $transformer = new SellerCustomPoliciesTransformer($sellerCustomPolicyTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(SellerCustomPoliciesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, SellerCustomPoliciesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\PaymentMethodBrandInterface;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodBrandsTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodBrandsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodBrandTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(PaymentMethodBrandsTransformer::class)]
final class PaymentMethodBrandsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(PaymentMethodBrandInterface::class);
        $second = self::createStub(PaymentMethodBrandInterface::class);

        $paymentMethodBrandTransformer = self::createStub(PaymentMethodBrandTransformerInterface::class);
        $paymentMethodBrandTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new PaymentMethodBrandsTransformer($paymentMethodBrandTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $paymentMethodBrandTransformer = self::createStub(PaymentMethodBrandTransformerInterface::class);

        $transformer = new PaymentMethodBrandsTransformer($paymentMethodBrandTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(PaymentMethodBrandInterface::class);

        $paymentMethodBrandTransformer = self::createMock(PaymentMethodBrandTransformerInterface::class);
        $paymentMethodBrandTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new PaymentMethodBrandsTransformer($paymentMethodBrandTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $paymentMethodBrandTransformer = self::createStub(PaymentMethodBrandTransformerInterface::class);

        $transformer = new PaymentMethodBrandsTransformer($paymentMethodBrandTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(PaymentMethodBrandsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, PaymentMethodBrandsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

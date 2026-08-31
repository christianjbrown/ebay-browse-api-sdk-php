<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\PaymentMethodInterface;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodsTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(PaymentMethodsTransformer::class)]
final class PaymentMethodsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['first'], ['second']];

        $first = self::createStub(PaymentMethodInterface::class);
        $second = self::createStub(PaymentMethodInterface::class);

        $paymentMethodTransformer = self::createStub(PaymentMethodTransformerInterface::class);
        $paymentMethodTransformer->method('transform')
            ->willReturnMap(
                [
                    [['first'], $first],
                    [['second'], $second],
                ]
            );

        $transformer = new PaymentMethodsTransformer($paymentMethodTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $paymentMethodTransformer = self::createStub(PaymentMethodTransformerInterface::class);

        $transformer = new PaymentMethodsTransformer($paymentMethodTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $first = self::createStub(PaymentMethodInterface::class);

        $paymentMethodTransformer = self::createMock(PaymentMethodTransformerInterface::class);
        $paymentMethodTransformer->expects(self::once())->method('transform')
            ->with(['first'])
            ->willReturn($first);

        $transformer = new PaymentMethodsTransformer($paymentMethodTransformer);

        self::assertSame([$first], $transformer->transform([['first']]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $paymentMethodTransformer = self::createStub(PaymentMethodTransformerInterface::class);

        $transformer = new PaymentMethodsTransformer($paymentMethodTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(PaymentMethodsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, PaymentMethodsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\TimeDuration;
use ChristianBrown\EBay\Browse\Transformer\TimeDurationTransformer;
use ChristianBrown\EBay\Browse\Transformer\TimeDurationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(TimeDuration::class)]
#[CoversClass(TimeDurationTransformer::class)]
final class TimeDurationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            TimeDurationTransformerInterface::KEY_UNIT => 'v_0',
            TimeDurationTransformerInterface::KEY_VALUE => 101,
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getUnit());
        self::assertSame(101, $actual->getValue());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[TimeDurationTransformerInterface::KEY_UNIT => 42]])]
    public function testTransformThrowsOnInvalidUnit(array $data): void
    {
        $transformer = $this->buildTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(TimeDurationTransformerInterface::UNEXPECTED_STRING_SPRINTF, TimeDurationTransformerInterface::KEY_UNIT));

        $transformer->transform($data);
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[TimeDurationTransformerInterface::KEY_UNIT => 'v_0']])]
    #[TestWith([[TimeDurationTransformerInterface::KEY_UNIT => 'v_0', TimeDurationTransformerInterface::KEY_VALUE => 'not-an-int']])]
    public function testTransformThrowsOnInvalidValue(array $data): void
    {
        $transformer = $this->buildTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(TimeDurationTransformerInterface::UNEXPECTED_INTEGER_SPRINTF, TimeDurationTransformerInterface::KEY_VALUE));

        $transformer->transform($data);
    }

    private function buildTransformer(): TimeDurationTransformer
    {
        return new TimeDurationTransformer();
    }
}

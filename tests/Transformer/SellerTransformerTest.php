<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\Seller;
use ChristianBrown\EBay\Browse\Model\SellerInterface;
use ChristianBrown\EBay\Browse\Model\SellerLegalInfoInterface;
use ChristianBrown\EBay\Browse\Transformer\SellerLegalInfoTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\SellerTransformer;
use ChristianBrown\EBay\Browse\Transformer\SellerTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Seller::class)]
#[CoversClass(SellerTransformer::class)]
final class SellerTransformerTest extends TestCase
{
    private ?SellerLegalInfoInterface $sellerLegalInfo = null;

    public function testTransform(): void
    {
        $data = [
            SellerTransformerInterface::KEY_USERNAME => 'v_0',
            SellerTransformerInterface::KEY_FEEDBACK_PERCENTAGE => 'v_1',
            SellerTransformerInterface::KEY_FEEDBACK_SCORE => 102,
            SellerTransformerInterface::KEY_SELLER_ACCOUNT_TYPE => 'v_3',
            SellerTransformerInterface::KEY_SELLER_LEGAL_INFO => ['raw_sellerLegalInfo'],
            SellerTransformerInterface::KEY_USER_ID => 'v_4',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getUsername());
        self::assertSame('v_1', $actual->getFeedbackPercentage());
        self::assertSame(102, $actual->getFeedbackScore());
        self::assertSame('v_3', $actual->getSellerAccountType());
        self::assertSame($this->sellerLegalInfo, $actual->getSellerLegalInfo());
        self::assertSame('v_4', $actual->getUserId());
    }

    /**
     * @param array<string, mixed>           $data
     * @param Closure(SellerInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(SellerInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [SellerTransformerInterface::KEY_USERNAME => 'v_0'];

        yield 'allOptionalAbsent' => [
            $base,
            static function (SellerInterface $model): void {
                self::assertNull($model->getFeedbackPercentage());
                self::assertNull($model->getFeedbackScore());
                self::assertNull($model->getSellerAccountType());
                self::assertNull($model->getSellerLegalInfo());
                self::assertNull($model->getUserId());
            },
        ];

        yield 'feedbackPercentageWrongType' => [
            [...$base, SellerTransformerInterface::KEY_FEEDBACK_PERCENTAGE => 42],
            static function (SellerInterface $model): void {
                self::assertNull($model->getFeedbackPercentage());
            },
        ];

        yield 'feedbackScoreWrongType' => [
            [...$base, SellerTransformerInterface::KEY_FEEDBACK_SCORE => 'x'],
            static function (SellerInterface $model): void {
                self::assertNull($model->getFeedbackScore());
            },
        ];

        yield 'feedbackScoreZero' => [
            [...$base, SellerTransformerInterface::KEY_FEEDBACK_SCORE => 0],
            static function (SellerInterface $model): void {
                self::assertSame(0, $model->getFeedbackScore());
            },
        ];

        yield 'sellerAccountTypeWrongType' => [
            [...$base, SellerTransformerInterface::KEY_SELLER_ACCOUNT_TYPE => 42],
            static function (SellerInterface $model): void {
                self::assertNull($model->getSellerAccountType());
            },
        ];

        yield 'sellerLegalInfoWrongType' => [
            [...$base, SellerTransformerInterface::KEY_SELLER_LEGAL_INFO => 'x'],
            static function (SellerInterface $model): void {
                self::assertNull($model->getSellerLegalInfo());
            },
        ];

        yield 'userIdWrongType' => [
            [...$base, SellerTransformerInterface::KEY_USER_ID => 42],
            static function (SellerInterface $model): void {
                self::assertNull($model->getUserId());
            },
        ];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[SellerTransformerInterface::KEY_USERNAME => 42]])]
    public function testTransformThrowsOnInvalidUsername(array $data): void
    {
        $transformer = $this->buildTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(SellerTransformerInterface::UNEXPECTED_STRING_SPRINTF, SellerTransformerInterface::KEY_USERNAME));

        $transformer->transform($data);
    }

    private function buildTransformer(): SellerTransformer
    {
        $this->sellerLegalInfo = self::createStub(SellerLegalInfoInterface::class);

        $sellerLegalInfoTransformer = self::createStub(SellerLegalInfoTransformerInterface::class);
        $sellerLegalInfoTransformer->method('transform')->willReturn($this->sellerLegalInfo);

        return new SellerTransformer($sellerLegalInfoTransformer);
    }
}

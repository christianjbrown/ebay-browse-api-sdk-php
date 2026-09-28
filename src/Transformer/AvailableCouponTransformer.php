<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\AvailableCoupon;
use ChristianBrown\EBay\Browse\Model\AvailableCouponInterface;

use function is_array;
use function is_string;

final class AvailableCouponTransformer implements AvailableCouponTransformerInterface
{
    private ConvertedAmountTransformerInterface $convertedAmountTransformer;
    private CouponConstraintTransformerInterface $couponConstraintTransformer;

    public function __construct(ConvertedAmountTransformerInterface $convertedAmountTransformer, CouponConstraintTransformerInterface $couponConstraintTransformer)
    {
        $this->convertedAmountTransformer = $convertedAmountTransformer;
        $this->couponConstraintTransformer = $couponConstraintTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AvailableCouponInterface
    {
        $availableCoupon = new AvailableCoupon();

        $this->applyConstraint($availableCoupon, $data);
        $this->applyDiscountAmount($availableCoupon, $data);
        self::applyDiscountType($availableCoupon, $data);
        self::applyMessage($availableCoupon, $data);
        self::applyRedemptionCode($availableCoupon, $data);
        self::applyTermsWebUrl($availableCoupon, $data);

        return $availableCoupon;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyConstraint(AvailableCoupon $availableCoupon, array $data): void
    {
        if (empty($data[self::KEY_CONSTRAINT])) {
            return;
        }
        if (!is_array($data[self::KEY_CONSTRAINT])) {
            return;
        }
        $availableCoupon->setConstraint($this->couponConstraintTransformer->transform($data[self::KEY_CONSTRAINT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDiscountAmount(AvailableCoupon $availableCoupon, array $data): void
    {
        if (empty($data[self::KEY_DISCOUNT_AMOUNT])) {
            return;
        }
        if (!is_array($data[self::KEY_DISCOUNT_AMOUNT])) {
            return;
        }
        $availableCoupon->setDiscountAmount($this->convertedAmountTransformer->transform($data[self::KEY_DISCOUNT_AMOUNT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDiscountType(AvailableCoupon $availableCoupon, array $data): void
    {
        if (empty($data[self::KEY_DISCOUNT_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_DISCOUNT_TYPE])) {
            return;
        }
        $availableCoupon->setDiscountType($data[self::KEY_DISCOUNT_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMessage(AvailableCoupon $availableCoupon, array $data): void
    {
        if (empty($data[self::KEY_MESSAGE])) {
            return;
        }
        if (!is_string($data[self::KEY_MESSAGE])) {
            return;
        }
        $availableCoupon->setMessage($data[self::KEY_MESSAGE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRedemptionCode(AvailableCoupon $availableCoupon, array $data): void
    {
        if (empty($data[self::KEY_REDEMPTION_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_REDEMPTION_CODE])) {
            return;
        }
        $availableCoupon->setRedemptionCode($data[self::KEY_REDEMPTION_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTermsWebUrl(AvailableCoupon $availableCoupon, array $data): void
    {
        if (empty($data[self::KEY_TERMS_WEB_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_TERMS_WEB_URL])) {
            return;
        }
        $availableCoupon->setTermsWebUrl($data[self::KEY_TERMS_WEB_URL]);
    }
}

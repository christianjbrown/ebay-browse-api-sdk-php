<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\CouponConstraint;
use ChristianBrown\EBay\Browse\Model\CouponConstraintInterface;

use function is_string;

final class CouponConstraintTransformer implements CouponConstraintTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CouponConstraintInterface
    {
        $couponConstraint = new CouponConstraint();

        self::applyExpirationDate($couponConstraint, $data);

        return $couponConstraint;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyExpirationDate(CouponConstraint $couponConstraint, array $data): void
    {
        if (empty($data[self::KEY_EXPIRATION_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_EXPIRATION_DATE])) {
            return;
        }
        $couponConstraint->setExpirationDate($data[self::KEY_EXPIRATION_DATE]);
    }
}

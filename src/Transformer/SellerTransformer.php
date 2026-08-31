<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\Seller;
use ChristianBrown\EBay\Browse\Model\SellerInterface;

use function is_int;
use function is_string;
use function sprintf;

final class SellerTransformer implements SellerTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SellerInterface
    {
        if (empty($data[self::KEY_USERNAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_USERNAME));
        }
        if (!is_string($data[self::KEY_USERNAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_USERNAME));
        }
        $seller = new Seller($data[self::KEY_USERNAME]);

        self::applyFeedbackPercentage($seller, $data);
        self::applyFeedbackScore($seller, $data);
        self::applySellerAccountType($seller, $data);

        return $seller;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFeedbackPercentage(Seller $seller, array $data): void
    {
        if (empty($data[self::KEY_FEEDBACK_PERCENTAGE])) {
            return;
        }
        if (!is_string($data[self::KEY_FEEDBACK_PERCENTAGE])) {
            return;
        }
        $seller->setFeedbackPercentage($data[self::KEY_FEEDBACK_PERCENTAGE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFeedbackScore(Seller $seller, array $data): void
    {
        if (!isset($data[self::KEY_FEEDBACK_SCORE])) {
            return;
        }
        if (!is_int($data[self::KEY_FEEDBACK_SCORE])) {
            return;
        }
        $seller->setFeedbackScore($data[self::KEY_FEEDBACK_SCORE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySellerAccountType(Seller $seller, array $data): void
    {
        if (empty($data[self::KEY_SELLER_ACCOUNT_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_SELLER_ACCOUNT_TYPE])) {
            return;
        }
        $seller->setSellerAccountType($data[self::KEY_SELLER_ACCOUNT_TYPE]);
    }
}

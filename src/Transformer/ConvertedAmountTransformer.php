<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ConvertedAmount;
use ChristianBrown\EBay\Browse\Model\ConvertedAmountInterface;

use function is_string;
use function sprintf;

final class ConvertedAmountTransformer implements ConvertedAmountTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ConvertedAmountInterface
    {
        if (empty($data[self::KEY_CURRENCY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CURRENCY));
        }
        if (!is_string($data[self::KEY_CURRENCY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CURRENCY));
        }
        if (empty($data[self::KEY_VALUE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_VALUE));
        }
        if (!is_string($data[self::KEY_VALUE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_VALUE));
        }
        $convertedAmount = new ConvertedAmount($data[self::KEY_CURRENCY], $data[self::KEY_VALUE]);

        self::applyConvertedFromCurrency($convertedAmount, $data);
        self::applyConvertedFromValue($convertedAmount, $data);

        return $convertedAmount;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConvertedFromCurrency(ConvertedAmount $convertedAmount, array $data): void
    {
        if (empty($data[self::KEY_CONVERTED_FROM_CURRENCY])) {
            return;
        }
        if (!is_string($data[self::KEY_CONVERTED_FROM_CURRENCY])) {
            return;
        }
        $convertedAmount->setConvertedFromCurrency($data[self::KEY_CONVERTED_FROM_CURRENCY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConvertedFromValue(ConvertedAmount $convertedAmount, array $data): void
    {
        if (empty($data[self::KEY_CONVERTED_FROM_VALUE])) {
            return;
        }
        if (!is_string($data[self::KEY_CONVERTED_FROM_VALUE])) {
            return;
        }
        $convertedAmount->setConvertedFromValue($data[self::KEY_CONVERTED_FROM_VALUE]);
    }
}

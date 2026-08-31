<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ConvertedAmountInterface;

interface ConvertedAmountTransformerInterface
{
    public const string KEY_CONVERTED_FROM_CURRENCY = 'convertedFromCurrency';
    public const string KEY_CONVERTED_FROM_VALUE = 'convertedFromValue';
    public const string KEY_CURRENCY = 'currency';
    public const string KEY_VALUE = 'value';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ConvertedAmountInterface;
}

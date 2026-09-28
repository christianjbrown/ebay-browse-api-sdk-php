<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\AvailableCouponInterface;

interface AvailableCouponTransformerInterface
{
    public const string KEY_CONSTRAINT = 'constraint';
    public const string KEY_DISCOUNT_AMOUNT = 'discountAmount';
    public const string KEY_DISCOUNT_TYPE = 'discountType';
    public const string KEY_MESSAGE = 'message';
    public const string KEY_REDEMPTION_CODE = 'redemptionCode';
    public const string KEY_TERMS_WEB_URL = 'termsWebUrl';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AvailableCouponInterface;
}

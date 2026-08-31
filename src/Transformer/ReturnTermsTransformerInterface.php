<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ReturnTermsInterface;

interface ReturnTermsTransformerInterface
{
    public const string KEY_EXTENDED_HOLIDAY_RETURNS_OFFERED = 'extendedHolidayReturnsOffered';
    public const string KEY_REFUND_METHOD = 'refundMethod';
    public const string KEY_RESTOCKING_FEE_PERCENTAGE = 'restockingFeePercentage';
    public const string KEY_RETURN_INSTRUCTIONS = 'returnInstructions';
    public const string KEY_RETURN_METHOD = 'returnMethod';
    public const string KEY_RETURN_PERIOD = 'returnPeriod';
    public const string KEY_RETURN_SHIPPING_COST_PAYER = 'returnShippingCostPayer';
    public const string KEY_RETURNS_ACCEPTED = 'returnsAccepted';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ReturnTermsInterface;
}

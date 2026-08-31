<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ReturnTerms;
use ChristianBrown\EBay\Browse\Model\ReturnTermsInterface;

use function is_array;
use function is_bool;
use function is_string;

final class ReturnTermsTransformer implements ReturnTermsTransformerInterface
{
    private TimeDurationTransformerInterface $timeDurationTransformer;

    public function __construct(TimeDurationTransformerInterface $timeDurationTransformer)
    {
        $this->timeDurationTransformer = $timeDurationTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ReturnTermsInterface
    {
        $returnTerms = new ReturnTerms();

        self::applyExtendedHolidayReturnsOffered($returnTerms, $data);
        self::applyRefundMethod($returnTerms, $data);
        self::applyRestockingFeePercentage($returnTerms, $data);
        self::applyReturnInstructions($returnTerms, $data);
        self::applyReturnMethod($returnTerms, $data);
        $this->applyReturnPeriod($returnTerms, $data);
        self::applyReturnShippingCostPayer($returnTerms, $data);
        self::applyReturnsAccepted($returnTerms, $data);

        return $returnTerms;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyExtendedHolidayReturnsOffered(ReturnTerms $returnTerms, array $data): void
    {
        if (!isset($data[self::KEY_EXTENDED_HOLIDAY_RETURNS_OFFERED])) {
            return;
        }
        if (!is_bool($data[self::KEY_EXTENDED_HOLIDAY_RETURNS_OFFERED])) {
            return;
        }
        $returnTerms->setExtendedHolidayReturnsOffered($data[self::KEY_EXTENDED_HOLIDAY_RETURNS_OFFERED]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRefundMethod(ReturnTerms $returnTerms, array $data): void
    {
        if (empty($data[self::KEY_REFUND_METHOD])) {
            return;
        }
        if (!is_string($data[self::KEY_REFUND_METHOD])) {
            return;
        }
        $returnTerms->setRefundMethod($data[self::KEY_REFUND_METHOD]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRestockingFeePercentage(ReturnTerms $returnTerms, array $data): void
    {
        if (empty($data[self::KEY_RESTOCKING_FEE_PERCENTAGE])) {
            return;
        }
        if (!is_string($data[self::KEY_RESTOCKING_FEE_PERCENTAGE])) {
            return;
        }
        $returnTerms->setRestockingFeePercentage($data[self::KEY_RESTOCKING_FEE_PERCENTAGE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyReturnInstructions(ReturnTerms $returnTerms, array $data): void
    {
        if (empty($data[self::KEY_RETURN_INSTRUCTIONS])) {
            return;
        }
        if (!is_string($data[self::KEY_RETURN_INSTRUCTIONS])) {
            return;
        }
        $returnTerms->setReturnInstructions($data[self::KEY_RETURN_INSTRUCTIONS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyReturnMethod(ReturnTerms $returnTerms, array $data): void
    {
        if (empty($data[self::KEY_RETURN_METHOD])) {
            return;
        }
        if (!is_string($data[self::KEY_RETURN_METHOD])) {
            return;
        }
        $returnTerms->setReturnMethod($data[self::KEY_RETURN_METHOD]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyReturnPeriod(ReturnTerms $returnTerms, array $data): void
    {
        if (empty($data[self::KEY_RETURN_PERIOD])) {
            return;
        }
        if (!is_array($data[self::KEY_RETURN_PERIOD])) {
            return;
        }
        $returnTerms->setReturnPeriod($this->timeDurationTransformer->transform($data[self::KEY_RETURN_PERIOD]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyReturnsAccepted(ReturnTerms $returnTerms, array $data): void
    {
        if (!isset($data[self::KEY_RETURNS_ACCEPTED])) {
            return;
        }
        if (!is_bool($data[self::KEY_RETURNS_ACCEPTED])) {
            return;
        }
        $returnTerms->setReturnsAccepted($data[self::KEY_RETURNS_ACCEPTED]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyReturnShippingCostPayer(ReturnTerms $returnTerms, array $data): void
    {
        if (empty($data[self::KEY_RETURN_SHIPPING_COST_PAYER])) {
            return;
        }
        if (!is_string($data[self::KEY_RETURN_SHIPPING_COST_PAYER])) {
            return;
        }
        $returnTerms->setReturnShippingCostPayer($data[self::KEY_RETURN_SHIPPING_COST_PAYER]);
    }
}

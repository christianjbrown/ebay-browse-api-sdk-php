<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ShippingOption;
use ChristianBrown\EBay\Browse\Model\ShippingOptionInterface;

use function is_array;
use function is_bool;
use function is_int;
use function is_string;
use function strtotime;

final class ShippingOptionTransformer implements ShippingOptionTransformerInterface
{
    private ConvertedAmountTransformerInterface $convertedAmountTransformer;

    public function __construct(ConvertedAmountTransformerInterface $convertedAmountTransformer)
    {
        $this->convertedAmountTransformer = $convertedAmountTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ShippingOptionInterface
    {
        $shippingOption = new ShippingOption();

        $this->applyAdditionalShippingCostPerUnit($shippingOption, $data);
        self::applyCutOffDateUsedForEstimate($shippingOption, $data);
        self::applyGuaranteedDelivery($shippingOption, $data);
        $this->applyImportCharges($shippingOption, $data);
        self::applyMaxEstimatedDeliveryDate($shippingOption, $data);
        self::applyMinEstimatedDeliveryDate($shippingOption, $data);
        self::applyQuantityUsedForEstimate($shippingOption, $data);
        self::applyShippingCarrierCode($shippingOption, $data);
        $this->applyShippingCost($shippingOption, $data);
        self::applyShippingCostType($shippingOption, $data);
        self::applyShippingServiceCode($shippingOption, $data);
        self::applyType($shippingOption, $data);

        return $shippingOption;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAdditionalShippingCostPerUnit(ShippingOption $shippingOption, array $data): void
    {
        if (empty($data[self::KEY_ADDITIONAL_SHIPPING_COST_PER_UNIT])) {
            return;
        }
        if (!is_array($data[self::KEY_ADDITIONAL_SHIPPING_COST_PER_UNIT])) {
            return;
        }
        $shippingOption->setAdditionalShippingCostPerUnit($this->convertedAmountTransformer->transform($data[self::KEY_ADDITIONAL_SHIPPING_COST_PER_UNIT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCutOffDateUsedForEstimate(ShippingOption $shippingOption, array $data): void
    {
        if (empty($data[self::KEY_CUT_OFF_DATE_USED_FOR_ESTIMATE])) {
            return;
        }
        if (!is_string($data[self::KEY_CUT_OFF_DATE_USED_FOR_ESTIMATE])) {
            return;
        }
        $timestamp = strtotime($data[self::KEY_CUT_OFF_DATE_USED_FOR_ESTIMATE]);
        if (false === $timestamp) {
            return;
        }
        $shippingOption->setCutOffDateUsedForEstimate($timestamp);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyGuaranteedDelivery(ShippingOption $shippingOption, array $data): void
    {
        if (!isset($data[self::KEY_GUARANTEED_DELIVERY])) {
            return;
        }
        if (!is_bool($data[self::KEY_GUARANTEED_DELIVERY])) {
            return;
        }
        $shippingOption->setGuaranteedDelivery($data[self::KEY_GUARANTEED_DELIVERY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyImportCharges(ShippingOption $shippingOption, array $data): void
    {
        if (empty($data[self::KEY_IMPORT_CHARGES])) {
            return;
        }
        if (!is_array($data[self::KEY_IMPORT_CHARGES])) {
            return;
        }
        $shippingOption->setImportCharges($this->convertedAmountTransformer->transform($data[self::KEY_IMPORT_CHARGES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMaxEstimatedDeliveryDate(ShippingOption $shippingOption, array $data): void
    {
        if (empty($data[self::KEY_MAX_ESTIMATED_DELIVERY_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_MAX_ESTIMATED_DELIVERY_DATE])) {
            return;
        }
        $timestamp = strtotime($data[self::KEY_MAX_ESTIMATED_DELIVERY_DATE]);
        if (false === $timestamp) {
            return;
        }
        $shippingOption->setMaxEstimatedDeliveryDate($timestamp);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMinEstimatedDeliveryDate(ShippingOption $shippingOption, array $data): void
    {
        if (empty($data[self::KEY_MIN_ESTIMATED_DELIVERY_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_MIN_ESTIMATED_DELIVERY_DATE])) {
            return;
        }
        $timestamp = strtotime($data[self::KEY_MIN_ESTIMATED_DELIVERY_DATE]);
        if (false === $timestamp) {
            return;
        }
        $shippingOption->setMinEstimatedDeliveryDate($timestamp);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyQuantityUsedForEstimate(ShippingOption $shippingOption, array $data): void
    {
        if (!isset($data[self::KEY_QUANTITY_USED_FOR_ESTIMATE])) {
            return;
        }
        if (!is_int($data[self::KEY_QUANTITY_USED_FOR_ESTIMATE])) {
            return;
        }
        $shippingOption->setQuantityUsedForEstimate($data[self::KEY_QUANTITY_USED_FOR_ESTIMATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyShippingCarrierCode(ShippingOption $shippingOption, array $data): void
    {
        if (empty($data[self::KEY_SHIPPING_CARRIER_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_SHIPPING_CARRIER_CODE])) {
            return;
        }
        $shippingOption->setShippingCarrierCode($data[self::KEY_SHIPPING_CARRIER_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyShippingCost(ShippingOption $shippingOption, array $data): void
    {
        if (empty($data[self::KEY_SHIPPING_COST])) {
            return;
        }
        if (!is_array($data[self::KEY_SHIPPING_COST])) {
            return;
        }
        $shippingOption->setShippingCost($this->convertedAmountTransformer->transform($data[self::KEY_SHIPPING_COST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyShippingCostType(ShippingOption $shippingOption, array $data): void
    {
        if (empty($data[self::KEY_SHIPPING_COST_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_SHIPPING_COST_TYPE])) {
            return;
        }
        $shippingOption->setShippingCostType($data[self::KEY_SHIPPING_COST_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyShippingServiceCode(ShippingOption $shippingOption, array $data): void
    {
        if (empty($data[self::KEY_SHIPPING_SERVICE_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_SHIPPING_SERVICE_CODE])) {
            return;
        }
        $shippingOption->setShippingServiceCode($data[self::KEY_SHIPPING_SERVICE_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyType(ShippingOption $shippingOption, array $data): void
    {
        if (empty($data[self::KEY_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_TYPE])) {
            return;
        }
        $shippingOption->setType($data[self::KEY_TYPE]);
    }
}

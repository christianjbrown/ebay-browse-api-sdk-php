<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\Item;

use function is_array;
use function is_bool;
use function is_int;
use function is_string;

final class ItemPricingTransformer implements ItemPricingTransformerInterface
{
    private AvailableCouponsTransformerInterface $availableCouponsTransformer;
    private ConvertedAmountTransformerInterface $convertedAmountTransformer;
    private MarketingPriceTransformerInterface $marketingPriceTransformer;
    private PaymentMethodsTransformerInterface $paymentMethodsTransformer;
    private StringsTransformerInterface $stringsTransformer;
    private TaxesTransformerInterface $taxesTransformer;

    public function __construct(AvailableCouponsTransformerInterface $availableCouponsTransformer, ConvertedAmountTransformerInterface $convertedAmountTransformer, MarketingPriceTransformerInterface $marketingPriceTransformer, PaymentMethodsTransformerInterface $paymentMethodsTransformer, StringsTransformerInterface $stringsTransformer, TaxesTransformerInterface $taxesTransformer)
    {
        $this->availableCouponsTransformer = $availableCouponsTransformer;
        $this->convertedAmountTransformer = $convertedAmountTransformer;
        $this->marketingPriceTransformer = $marketingPriceTransformer;
        $this->paymentMethodsTransformer = $paymentMethodsTransformer;
        $this->stringsTransformer = $stringsTransformer;
        $this->taxesTransformer = $taxesTransformer;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    public function apply(Item $item, array $data): void
    {
        $this->applyAvailableCoupons($item, $data);
        self::applyBidCount($item, $data);
        $this->applyBuyingOptions($item, $data);
        $this->applyCurrentBidPrice($item, $data);
        $this->applyEcoParticipationFee($item, $data);
        $this->applyMarketingPrice($item, $data);
        $this->applyMinimumPriceToBid($item, $data);
        $this->applyPaymentMethods($item, $data);
        $this->applyPrice($item, $data);
        self::applyPriceDisplayCondition($item, $data);
        self::applyReservePriceMet($item, $data);
        $this->applyTaxes($item, $data);
        self::applyUniqueBidderCount($item, $data);
        $this->applyUnitPrice($item, $data);
        self::applyUnitPricingMeasure($item, $data);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAvailableCoupons(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_AVAILABLE_COUPONS])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_AVAILABLE_COUPONS])) {
            return;
        }
        $item->setAvailableCoupons($this->availableCouponsTransformer->transform($data[ItemTransformerInterface::KEY_AVAILABLE_COUPONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBidCount(Item $item, array $data): void
    {
        if (!isset($data[ItemTransformerInterface::KEY_BID_COUNT])) {
            return;
        }
        if (!is_int($data[ItemTransformerInterface::KEY_BID_COUNT])) {
            return;
        }
        $item->setBidCount($data[ItemTransformerInterface::KEY_BID_COUNT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyBuyingOptions(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_BUYING_OPTIONS])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_BUYING_OPTIONS])) {
            return;
        }
        $item->setBuyingOptions($this->stringsTransformer->transform($data[ItemTransformerInterface::KEY_BUYING_OPTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCurrentBidPrice(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_CURRENT_BID_PRICE])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_CURRENT_BID_PRICE])) {
            return;
        }
        $item->setCurrentBidPrice($this->convertedAmountTransformer->transform($data[ItemTransformerInterface::KEY_CURRENT_BID_PRICE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyEcoParticipationFee(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_ECO_PARTICIPATION_FEE])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_ECO_PARTICIPATION_FEE])) {
            return;
        }
        $item->setEcoParticipationFee($this->convertedAmountTransformer->transform($data[ItemTransformerInterface::KEY_ECO_PARTICIPATION_FEE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyMarketingPrice(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_MARKETING_PRICE])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_MARKETING_PRICE])) {
            return;
        }
        $item->setMarketingPrice($this->marketingPriceTransformer->transform($data[ItemTransformerInterface::KEY_MARKETING_PRICE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyMinimumPriceToBid(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_MINIMUM_PRICE_TO_BID])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_MINIMUM_PRICE_TO_BID])) {
            return;
        }
        $item->setMinimumPriceToBid($this->convertedAmountTransformer->transform($data[ItemTransformerInterface::KEY_MINIMUM_PRICE_TO_BID]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPaymentMethods(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_PAYMENT_METHODS])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_PAYMENT_METHODS])) {
            return;
        }
        $item->setPaymentMethods($this->paymentMethodsTransformer->transform($data[ItemTransformerInterface::KEY_PAYMENT_METHODS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPrice(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_PRICE])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_PRICE])) {
            return;
        }
        $item->setPrice($this->convertedAmountTransformer->transform($data[ItemTransformerInterface::KEY_PRICE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPriceDisplayCondition(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_PRICE_DISPLAY_CONDITION])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_PRICE_DISPLAY_CONDITION])) {
            return;
        }
        $item->setPriceDisplayCondition($data[ItemTransformerInterface::KEY_PRICE_DISPLAY_CONDITION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyReservePriceMet(Item $item, array $data): void
    {
        if (!isset($data[ItemTransformerInterface::KEY_RESERVE_PRICE_MET])) {
            return;
        }
        if (!is_bool($data[ItemTransformerInterface::KEY_RESERVE_PRICE_MET])) {
            return;
        }
        $item->setReservePriceMet($data[ItemTransformerInterface::KEY_RESERVE_PRICE_MET]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTaxes(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_TAXES])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_TAXES])) {
            return;
        }
        $item->setTaxes($this->taxesTransformer->transform($data[ItemTransformerInterface::KEY_TAXES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUniqueBidderCount(Item $item, array $data): void
    {
        if (!isset($data[ItemTransformerInterface::KEY_UNIQUE_BIDDER_COUNT])) {
            return;
        }
        if (!is_int($data[ItemTransformerInterface::KEY_UNIQUE_BIDDER_COUNT])) {
            return;
        }
        $item->setUniqueBidderCount($data[ItemTransformerInterface::KEY_UNIQUE_BIDDER_COUNT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyUnitPrice(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_UNIT_PRICE])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_UNIT_PRICE])) {
            return;
        }
        $item->setUnitPrice($this->convertedAmountTransformer->transform($data[ItemTransformerInterface::KEY_UNIT_PRICE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUnitPricingMeasure(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_UNIT_PRICING_MEASURE])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_UNIT_PRICING_MEASURE])) {
            return;
        }
        $item->setUnitPricingMeasure($data[ItemTransformerInterface::KEY_UNIT_PRICING_MEASURE]);
    }
}

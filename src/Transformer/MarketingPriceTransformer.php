<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\MarketingPrice;
use ChristianBrown\EBay\Browse\Model\MarketingPriceInterface;

use function is_array;
use function is_string;

final class MarketingPriceTransformer implements MarketingPriceTransformerInterface
{
    private ConvertedAmountTransformerInterface $convertedAmountTransformer;

    public function __construct(ConvertedAmountTransformerInterface $convertedAmountTransformer)
    {
        $this->convertedAmountTransformer = $convertedAmountTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): MarketingPriceInterface
    {
        $marketingPrice = new MarketingPrice();

        $this->applyDiscountAmount($marketingPrice, $data);
        self::applyDiscountPercentage($marketingPrice, $data);
        $this->applyOriginalPrice($marketingPrice, $data);
        self::applyPriceTreatment($marketingPrice, $data);

        return $marketingPrice;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDiscountAmount(MarketingPrice $marketingPrice, array $data): void
    {
        if (empty($data[self::KEY_DISCOUNT_AMOUNT])) {
            return;
        }
        if (!is_array($data[self::KEY_DISCOUNT_AMOUNT])) {
            return;
        }
        $marketingPrice->setDiscountAmount($this->convertedAmountTransformer->transform($data[self::KEY_DISCOUNT_AMOUNT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDiscountPercentage(MarketingPrice $marketingPrice, array $data): void
    {
        if (empty($data[self::KEY_DISCOUNT_PERCENTAGE])) {
            return;
        }
        if (!is_string($data[self::KEY_DISCOUNT_PERCENTAGE])) {
            return;
        }
        $marketingPrice->setDiscountPercentage($data[self::KEY_DISCOUNT_PERCENTAGE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyOriginalPrice(MarketingPrice $marketingPrice, array $data): void
    {
        if (empty($data[self::KEY_ORIGINAL_PRICE])) {
            return;
        }
        if (!is_array($data[self::KEY_ORIGINAL_PRICE])) {
            return;
        }
        $marketingPrice->setOriginalPrice($this->convertedAmountTransformer->transform($data[self::KEY_ORIGINAL_PRICE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPriceTreatment(MarketingPrice $marketingPrice, array $data): void
    {
        if (empty($data[self::KEY_PRICE_TREATMENT])) {
            return;
        }
        if (!is_string($data[self::KEY_PRICE_TREATMENT])) {
            return;
        }
        $marketingPrice->setPriceTreatment($data[self::KEY_PRICE_TREATMENT]);
    }
}

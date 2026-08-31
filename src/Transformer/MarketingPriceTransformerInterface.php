<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\MarketingPriceInterface;

interface MarketingPriceTransformerInterface
{
    public const string KEY_DISCOUNT_AMOUNT = 'discountAmount';
    public const string KEY_DISCOUNT_PERCENTAGE = 'discountPercentage';
    public const string KEY_ORIGINAL_PRICE = 'originalPrice';
    public const string KEY_PRICE_TREATMENT = 'priceTreatment';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): MarketingPriceInterface;
}

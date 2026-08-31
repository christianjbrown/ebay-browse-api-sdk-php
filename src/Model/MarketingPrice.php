<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class MarketingPrice implements MarketingPriceInterface
{
    private ?ConvertedAmountInterface $discountAmount = null;
    private ?string $discountPercentage = null;
    private ?ConvertedAmountInterface $originalPrice = null;
    private ?string $priceTreatment = null;

    public function getDiscountAmount(): ?ConvertedAmountInterface
    {
        return $this->discountAmount;
    }

    public function getDiscountPercentage(): ?string
    {
        return $this->discountPercentage;
    }

    public function getOriginalPrice(): ?ConvertedAmountInterface
    {
        return $this->originalPrice;
    }

    public function getPriceTreatment(): ?string
    {
        return $this->priceTreatment;
    }

    public function setDiscountAmount(?ConvertedAmountInterface $value): MarketingPriceInterface
    {
        $this->discountAmount = $value;

        return $this;
    }

    public function setDiscountPercentage(?string $value): MarketingPriceInterface
    {
        $this->discountPercentage = $value;

        return $this;
    }

    public function setOriginalPrice(?ConvertedAmountInterface $value): MarketingPriceInterface
    {
        $this->originalPrice = $value;

        return $this;
    }

    public function setPriceTreatment(?string $value): MarketingPriceInterface
    {
        $this->priceTreatment = $value;

        return $this;
    }
}

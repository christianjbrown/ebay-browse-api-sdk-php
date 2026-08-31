<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface MarketingPriceInterface
{
    public function getDiscountAmount(): ?ConvertedAmountInterface;

    public function getDiscountPercentage(): ?string;

    public function getOriginalPrice(): ?ConvertedAmountInterface;

    public function getPriceTreatment(): ?string;

    public function setDiscountAmount(?ConvertedAmountInterface $value): self;

    public function setDiscountPercentage(?string $value): self;

    public function setOriginalPrice(?ConvertedAmountInterface $value): self;

    public function setPriceTreatment(?string $value): self;
}

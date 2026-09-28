<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ShippingOptionInterface
{
    public function getAdditionalShippingCostPerUnit(): ?ConvertedAmountInterface;

    public function getCutOffDateUsedForEstimate(): ?int;

    public function getFulfilledThrough(): ?string;

    public function getGuaranteedDelivery(): ?bool;

    public function getImportCharges(): ?ConvertedAmountInterface;

    public function getMaxEstimatedDeliveryDate(): ?int;

    public function getMinEstimatedDeliveryDate(): ?int;

    public function getQuantityUsedForEstimate(): ?int;

    public function getShippingCarrierCode(): ?string;

    public function getShippingCost(): ?ConvertedAmountInterface;

    public function getShippingCostType(): ?string;

    public function getShippingServiceCode(): ?string;

    public function getShipToLocationUsedForEstimate(): ?ShipToLocationInterface;

    public function getTrademarkSymbol(): ?string;

    public function getType(): ?string;

    public function setAdditionalShippingCostPerUnit(?ConvertedAmountInterface $value): self;

    public function setCutOffDateUsedForEstimate(?int $value): self;

    public function setFulfilledThrough(?string $value): self;

    public function setGuaranteedDelivery(?bool $value): self;

    public function setImportCharges(?ConvertedAmountInterface $value): self;

    public function setMaxEstimatedDeliveryDate(?int $value): self;

    public function setMinEstimatedDeliveryDate(?int $value): self;

    public function setQuantityUsedForEstimate(?int $value): self;

    public function setShippingCarrierCode(?string $value): self;

    public function setShippingCost(?ConvertedAmountInterface $value): self;

    public function setShippingCostType(?string $value): self;

    public function setShippingServiceCode(?string $value): self;

    public function setShipToLocationUsedForEstimate(?ShipToLocationInterface $value): self;

    public function setTrademarkSymbol(?string $value): self;

    public function setType(?string $value): self;
}

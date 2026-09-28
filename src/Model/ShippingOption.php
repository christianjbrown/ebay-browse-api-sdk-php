<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class ShippingOption implements ShippingOptionInterface
{
    private ?ConvertedAmountInterface $additionalShippingCostPerUnit = null;
    private ?int $cutOffDateUsedForEstimate = null;
    private ?string $fulfilledThrough = null;
    private ?bool $guaranteedDelivery = null;
    private ?ConvertedAmountInterface $importCharges = null;
    private ?int $maxEstimatedDeliveryDate = null;
    private ?int $minEstimatedDeliveryDate = null;
    private ?int $quantityUsedForEstimate = null;
    private ?string $shippingCarrierCode = null;
    private ?ConvertedAmountInterface $shippingCost = null;
    private ?string $shippingCostType = null;
    private ?string $shippingServiceCode = null;
    private ?ShipToLocationInterface $shipToLocationUsedForEstimate = null;
    private ?string $trademarkSymbol = null;
    private ?string $type = null;

    public function getAdditionalShippingCostPerUnit(): ?ConvertedAmountInterface
    {
        return $this->additionalShippingCostPerUnit;
    }

    public function getCutOffDateUsedForEstimate(): ?int
    {
        return $this->cutOffDateUsedForEstimate;
    }

    public function getFulfilledThrough(): ?string
    {
        return $this->fulfilledThrough;
    }

    public function getGuaranteedDelivery(): ?bool
    {
        return $this->guaranteedDelivery;
    }

    public function getImportCharges(): ?ConvertedAmountInterface
    {
        return $this->importCharges;
    }

    public function getMaxEstimatedDeliveryDate(): ?int
    {
        return $this->maxEstimatedDeliveryDate;
    }

    public function getMinEstimatedDeliveryDate(): ?int
    {
        return $this->minEstimatedDeliveryDate;
    }

    public function getQuantityUsedForEstimate(): ?int
    {
        return $this->quantityUsedForEstimate;
    }

    public function getShippingCarrierCode(): ?string
    {
        return $this->shippingCarrierCode;
    }

    public function getShippingCost(): ?ConvertedAmountInterface
    {
        return $this->shippingCost;
    }

    public function getShippingCostType(): ?string
    {
        return $this->shippingCostType;
    }

    public function getShippingServiceCode(): ?string
    {
        return $this->shippingServiceCode;
    }

    public function getShipToLocationUsedForEstimate(): ?ShipToLocationInterface
    {
        return $this->shipToLocationUsedForEstimate;
    }

    public function getTrademarkSymbol(): ?string
    {
        return $this->trademarkSymbol;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setAdditionalShippingCostPerUnit(?ConvertedAmountInterface $value): ShippingOptionInterface
    {
        $this->additionalShippingCostPerUnit = $value;

        return $this;
    }

    public function setCutOffDateUsedForEstimate(?int $value): ShippingOptionInterface
    {
        $this->cutOffDateUsedForEstimate = $value;

        return $this;
    }

    public function setFulfilledThrough(?string $value): ShippingOptionInterface
    {
        $this->fulfilledThrough = $value;

        return $this;
    }

    public function setGuaranteedDelivery(?bool $value): ShippingOptionInterface
    {
        $this->guaranteedDelivery = $value;

        return $this;
    }

    public function setImportCharges(?ConvertedAmountInterface $value): ShippingOptionInterface
    {
        $this->importCharges = $value;

        return $this;
    }

    public function setMaxEstimatedDeliveryDate(?int $value): ShippingOptionInterface
    {
        $this->maxEstimatedDeliveryDate = $value;

        return $this;
    }

    public function setMinEstimatedDeliveryDate(?int $value): ShippingOptionInterface
    {
        $this->minEstimatedDeliveryDate = $value;

        return $this;
    }

    public function setQuantityUsedForEstimate(?int $value): ShippingOptionInterface
    {
        $this->quantityUsedForEstimate = $value;

        return $this;
    }

    public function setShippingCarrierCode(?string $value): ShippingOptionInterface
    {
        $this->shippingCarrierCode = $value;

        return $this;
    }

    public function setShippingCost(?ConvertedAmountInterface $value): ShippingOptionInterface
    {
        $this->shippingCost = $value;

        return $this;
    }

    public function setShippingCostType(?string $value): ShippingOptionInterface
    {
        $this->shippingCostType = $value;

        return $this;
    }

    public function setShippingServiceCode(?string $value): ShippingOptionInterface
    {
        $this->shippingServiceCode = $value;

        return $this;
    }

    public function setShipToLocationUsedForEstimate(?ShipToLocationInterface $value): ShippingOptionInterface
    {
        $this->shipToLocationUsedForEstimate = $value;

        return $this;
    }

    public function setTrademarkSymbol(?string $value): ShippingOptionInterface
    {
        $this->trademarkSymbol = $value;

        return $this;
    }

    public function setType(?string $value): ShippingOptionInterface
    {
        $this->type = $value;

        return $this;
    }
}

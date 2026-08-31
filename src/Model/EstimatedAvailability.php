<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class EstimatedAvailability implements EstimatedAvailabilityInterface
{
    private ?int $availabilityThreshold = null;
    private ?string $availabilityThresholdType = null;

    /**
     * @var array<int, string>
     */
    private array $deliveryOptions = [];
    private ?string $estimatedAvailabilityStatus = null;
    private ?int $estimatedAvailableQuantity = null;
    private ?int $estimatedRemainingQuantity = null;
    private ?int $estimatedSoldQuantity = null;

    public function getAvailabilityThreshold(): ?int
    {
        return $this->availabilityThreshold;
    }

    public function getAvailabilityThresholdType(): ?string
    {
        return $this->availabilityThresholdType;
    }

    /**
     * @return array<int, string>
     */
    public function getDeliveryOptions(): array
    {
        return $this->deliveryOptions;
    }

    public function getEstimatedAvailabilityStatus(): ?string
    {
        return $this->estimatedAvailabilityStatus;
    }

    public function getEstimatedAvailableQuantity(): ?int
    {
        return $this->estimatedAvailableQuantity;
    }

    public function getEstimatedRemainingQuantity(): ?int
    {
        return $this->estimatedRemainingQuantity;
    }

    public function getEstimatedSoldQuantity(): ?int
    {
        return $this->estimatedSoldQuantity;
    }

    public function setAvailabilityThreshold(?int $value): EstimatedAvailabilityInterface
    {
        $this->availabilityThreshold = $value;

        return $this;
    }

    public function setAvailabilityThresholdType(?string $value): EstimatedAvailabilityInterface
    {
        $this->availabilityThresholdType = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setDeliveryOptions(array $value): EstimatedAvailabilityInterface
    {
        $this->deliveryOptions = $value;

        return $this;
    }

    public function setEstimatedAvailabilityStatus(?string $value): EstimatedAvailabilityInterface
    {
        $this->estimatedAvailabilityStatus = $value;

        return $this;
    }

    public function setEstimatedAvailableQuantity(?int $value): EstimatedAvailabilityInterface
    {
        $this->estimatedAvailableQuantity = $value;

        return $this;
    }

    public function setEstimatedRemainingQuantity(?int $value): EstimatedAvailabilityInterface
    {
        $this->estimatedRemainingQuantity = $value;

        return $this;
    }

    public function setEstimatedSoldQuantity(?int $value): EstimatedAvailabilityInterface
    {
        $this->estimatedSoldQuantity = $value;

        return $this;
    }
}

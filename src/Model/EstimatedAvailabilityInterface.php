<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface EstimatedAvailabilityInterface
{
    public function getAvailabilityThreshold(): ?int;

    public function getAvailabilityThresholdType(): ?string;

    /**
     * @return array<int, string>
     */
    public function getDeliveryOptions(): array;

    public function getEstimatedAvailabilityStatus(): ?string;

    public function getEstimatedAvailableQuantity(): ?int;

    public function getEstimatedRemainingQuantity(): ?int;

    public function getEstimatedSoldQuantity(): ?int;

    public function setAvailabilityThreshold(?int $value): self;

    public function setAvailabilityThresholdType(?string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setDeliveryOptions(array $value): self;

    public function setEstimatedAvailabilityStatus(?string $value): self;

    public function setEstimatedAvailableQuantity(?int $value): self;

    public function setEstimatedRemainingQuantity(?int $value): self;

    public function setEstimatedSoldQuantity(?int $value): self;
}

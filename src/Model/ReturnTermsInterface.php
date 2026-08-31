<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ReturnTermsInterface
{
    public function getExtendedHolidayReturnsOffered(): ?bool;

    public function getRefundMethod(): ?string;

    public function getRestockingFeePercentage(): ?string;

    public function getReturnInstructions(): ?string;

    public function getReturnMethod(): ?string;

    public function getReturnPeriod(): ?TimeDurationInterface;

    public function getReturnsAccepted(): ?bool;

    public function getReturnShippingCostPayer(): ?string;

    public function setExtendedHolidayReturnsOffered(?bool $value): self;

    public function setRefundMethod(?string $value): self;

    public function setRestockingFeePercentage(?string $value): self;

    public function setReturnInstructions(?string $value): self;

    public function setReturnMethod(?string $value): self;

    public function setReturnPeriod(?TimeDurationInterface $value): self;

    public function setReturnsAccepted(?bool $value): self;

    public function setReturnShippingCostPayer(?string $value): self;
}

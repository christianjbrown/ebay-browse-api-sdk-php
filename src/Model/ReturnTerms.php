<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class ReturnTerms implements ReturnTermsInterface
{
    private ?bool $extendedHolidayReturnsOffered = null;
    private ?string $refundMethod = null;
    private ?string $restockingFeePercentage = null;
    private ?string $returnInstructions = null;
    private ?string $returnMethod = null;
    private ?TimeDurationInterface $returnPeriod = null;
    private ?bool $returnsAccepted = null;
    private ?string $returnShippingCostPayer = null;

    public function getExtendedHolidayReturnsOffered(): ?bool
    {
        return $this->extendedHolidayReturnsOffered;
    }

    public function getRefundMethod(): ?string
    {
        return $this->refundMethod;
    }

    public function getRestockingFeePercentage(): ?string
    {
        return $this->restockingFeePercentage;
    }

    public function getReturnInstructions(): ?string
    {
        return $this->returnInstructions;
    }

    public function getReturnMethod(): ?string
    {
        return $this->returnMethod;
    }

    public function getReturnPeriod(): ?TimeDurationInterface
    {
        return $this->returnPeriod;
    }

    public function getReturnsAccepted(): ?bool
    {
        return $this->returnsAccepted;
    }

    public function getReturnShippingCostPayer(): ?string
    {
        return $this->returnShippingCostPayer;
    }

    public function setExtendedHolidayReturnsOffered(?bool $value): ReturnTermsInterface
    {
        $this->extendedHolidayReturnsOffered = $value;

        return $this;
    }

    public function setRefundMethod(?string $value): ReturnTermsInterface
    {
        $this->refundMethod = $value;

        return $this;
    }

    public function setRestockingFeePercentage(?string $value): ReturnTermsInterface
    {
        $this->restockingFeePercentage = $value;

        return $this;
    }

    public function setReturnInstructions(?string $value): ReturnTermsInterface
    {
        $this->returnInstructions = $value;

        return $this;
    }

    public function setReturnMethod(?string $value): ReturnTermsInterface
    {
        $this->returnMethod = $value;

        return $this;
    }

    public function setReturnPeriod(?TimeDurationInterface $value): ReturnTermsInterface
    {
        $this->returnPeriod = $value;

        return $this;
    }

    public function setReturnsAccepted(?bool $value): ReturnTermsInterface
    {
        $this->returnsAccepted = $value;

        return $this;
    }

    public function setReturnShippingCostPayer(?string $value): ReturnTermsInterface
    {
        $this->returnShippingCostPayer = $value;

        return $this;
    }
}

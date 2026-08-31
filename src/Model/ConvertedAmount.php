<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class ConvertedAmount implements ConvertedAmountInterface
{
    private ?string $convertedFromCurrency = null;
    private ?string $convertedFromValue = null;
    private string $currency;
    private string $value;

    public function __construct(string $currency, string $value)
    {
        $this->currency = $currency;
        $this->value = $value;
    }

    public function getConvertedFromCurrency(): ?string
    {
        return $this->convertedFromCurrency;
    }

    public function getConvertedFromValue(): ?string
    {
        return $this->convertedFromValue;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setConvertedFromCurrency(?string $value): ConvertedAmountInterface
    {
        $this->convertedFromCurrency = $value;

        return $this;
    }

    public function setConvertedFromValue(?string $value): ConvertedAmountInterface
    {
        $this->convertedFromValue = $value;

        return $this;
    }

    public function setCurrency(string $value): ConvertedAmountInterface
    {
        $this->currency = $value;

        return $this;
    }

    public function setValue(string $value): ConvertedAmountInterface
    {
        $this->value = $value;

        return $this;
    }
}

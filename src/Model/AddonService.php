<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class AddonService implements AddonServiceInterface
{
    private ?string $selection = null;
    private ?ConvertedAmountInterface $serviceFee = null;
    private ?string $serviceId = null;
    private ?string $serviceType = null;

    public function getSelection(): ?string
    {
        return $this->selection;
    }

    public function getServiceFee(): ?ConvertedAmountInterface
    {
        return $this->serviceFee;
    }

    public function getServiceId(): ?string
    {
        return $this->serviceId;
    }

    public function getServiceType(): ?string
    {
        return $this->serviceType;
    }

    public function setSelection(?string $value): AddonServiceInterface
    {
        $this->selection = $value;

        return $this;
    }

    public function setServiceFee(?ConvertedAmountInterface $value): AddonServiceInterface
    {
        $this->serviceFee = $value;

        return $this;
    }

    public function setServiceId(?string $value): AddonServiceInterface
    {
        $this->serviceId = $value;

        return $this;
    }

    public function setServiceType(?string $value): AddonServiceInterface
    {
        $this->serviceType = $value;

        return $this;
    }
}

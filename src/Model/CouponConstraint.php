<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class CouponConstraint implements CouponConstraintInterface
{
    private ?string $expirationDate = null;

    public function getExpirationDate(): ?string
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(?string $value): CouponConstraintInterface
    {
        $this->expirationDate = $value;

        return $this;
    }
}

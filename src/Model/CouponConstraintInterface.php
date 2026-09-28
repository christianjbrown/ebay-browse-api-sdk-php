<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface CouponConstraintInterface
{
    public function getExpirationDate(): ?string;

    public function setExpirationDate(?string $value): self;
}

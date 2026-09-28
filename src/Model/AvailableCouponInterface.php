<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface AvailableCouponInterface
{
    public function getConstraint(): ?CouponConstraintInterface;

    public function getDiscountAmount(): ?ConvertedAmountInterface;

    public function getDiscountType(): ?string;

    public function getMessage(): ?string;

    public function getRedemptionCode(): ?string;

    public function getTermsWebUrl(): ?string;

    public function setConstraint(?CouponConstraintInterface $value): self;

    public function setDiscountAmount(?ConvertedAmountInterface $value): self;

    public function setDiscountType(?string $value): self;

    public function setMessage(?string $value): self;

    public function setRedemptionCode(?string $value): self;

    public function setTermsWebUrl(?string $value): self;
}

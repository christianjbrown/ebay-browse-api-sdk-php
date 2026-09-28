<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class AvailableCoupon implements AvailableCouponInterface
{
    private ?CouponConstraintInterface $constraint = null;
    private ?ConvertedAmountInterface $discountAmount = null;
    private ?string $discountType = null;
    private ?string $message = null;
    private ?string $redemptionCode = null;
    private ?string $termsWebUrl = null;

    public function getConstraint(): ?CouponConstraintInterface
    {
        return $this->constraint;
    }

    public function getDiscountAmount(): ?ConvertedAmountInterface
    {
        return $this->discountAmount;
    }

    public function getDiscountType(): ?string
    {
        return $this->discountType;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getRedemptionCode(): ?string
    {
        return $this->redemptionCode;
    }

    public function getTermsWebUrl(): ?string
    {
        return $this->termsWebUrl;
    }

    public function setConstraint(?CouponConstraintInterface $value): AvailableCouponInterface
    {
        $this->constraint = $value;

        return $this;
    }

    public function setDiscountAmount(?ConvertedAmountInterface $value): AvailableCouponInterface
    {
        $this->discountAmount = $value;

        return $this;
    }

    public function setDiscountType(?string $value): AvailableCouponInterface
    {
        $this->discountType = $value;

        return $this;
    }

    public function setMessage(?string $value): AvailableCouponInterface
    {
        $this->message = $value;

        return $this;
    }

    public function setRedemptionCode(?string $value): AvailableCouponInterface
    {
        $this->redemptionCode = $value;

        return $this;
    }

    public function setTermsWebUrl(?string $value): AvailableCouponInterface
    {
        $this->termsWebUrl = $value;

        return $this;
    }
}

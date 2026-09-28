<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class Seller implements SellerInterface
{
    private ?string $feedbackPercentage = null;
    private ?int $feedbackScore = null;
    private ?string $sellerAccountType = null;
    private ?SellerLegalInfoInterface $sellerLegalInfo = null;
    private ?string $userId = null;
    private string $username;

    public function __construct(string $username)
    {
        $this->username = $username;
    }

    public function getFeedbackPercentage(): ?string
    {
        return $this->feedbackPercentage;
    }

    public function getFeedbackScore(): ?int
    {
        return $this->feedbackScore;
    }

    public function getSellerAccountType(): ?string
    {
        return $this->sellerAccountType;
    }

    public function getSellerLegalInfo(): ?SellerLegalInfoInterface
    {
        return $this->sellerLegalInfo;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setFeedbackPercentage(?string $value): SellerInterface
    {
        $this->feedbackPercentage = $value;

        return $this;
    }

    public function setFeedbackScore(?int $value): SellerInterface
    {
        $this->feedbackScore = $value;

        return $this;
    }

    public function setSellerAccountType(?string $value): SellerInterface
    {
        $this->sellerAccountType = $value;

        return $this;
    }

    public function setSellerLegalInfo(?SellerLegalInfoInterface $value): SellerInterface
    {
        $this->sellerLegalInfo = $value;

        return $this;
    }

    public function setUserId(?string $value): SellerInterface
    {
        $this->userId = $value;

        return $this;
    }

    public function setUsername(string $value): SellerInterface
    {
        $this->username = $value;

        return $this;
    }
}

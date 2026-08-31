<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface SellerInterface
{
    public function getFeedbackPercentage(): ?string;

    public function getFeedbackScore(): ?int;

    public function getSellerAccountType(): ?string;

    public function getUsername(): string;

    public function setFeedbackPercentage(?string $value): self;

    public function setFeedbackScore(?int $value): self;

    public function setSellerAccountType(?string $value): self;

    public function setUsername(string $value): self;
}

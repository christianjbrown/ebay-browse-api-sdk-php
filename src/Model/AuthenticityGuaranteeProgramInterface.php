<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface AuthenticityGuaranteeProgramInterface
{
    public function getDescription(): ?string;

    public function getTermsWebUrl(): ?string;

    public function setDescription(?string $value): self;

    public function setTermsWebUrl(?string $value): self;
}

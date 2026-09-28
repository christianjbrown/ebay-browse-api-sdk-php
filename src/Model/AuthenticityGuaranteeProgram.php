<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class AuthenticityGuaranteeProgram implements AuthenticityGuaranteeProgramInterface
{
    private ?string $description = null;
    private ?string $termsWebUrl = null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getTermsWebUrl(): ?string
    {
        return $this->termsWebUrl;
    }

    public function setDescription(?string $value): AuthenticityGuaranteeProgramInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setTermsWebUrl(?string $value): AuthenticityGuaranteeProgramInterface
    {
        $this->termsWebUrl = $value;

        return $this;
    }
}

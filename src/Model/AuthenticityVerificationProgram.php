<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class AuthenticityVerificationProgram implements AuthenticityVerificationProgramInterface
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

    public function setDescription(?string $value): AuthenticityVerificationProgramInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setTermsWebUrl(?string $value): AuthenticityVerificationProgramInterface
    {
        $this->termsWebUrl = $value;

        return $this;
    }
}

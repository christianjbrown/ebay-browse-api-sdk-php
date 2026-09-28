<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\AuthenticityVerificationProgram;
use ChristianBrown\EBay\Browse\Model\AuthenticityVerificationProgramInterface;

use function is_string;

final class AuthenticityVerificationProgramTransformer implements AuthenticityVerificationProgramTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AuthenticityVerificationProgramInterface
    {
        $authenticityVerificationProgram = new AuthenticityVerificationProgram();

        self::applyDescription($authenticityVerificationProgram, $data);
        self::applyTermsWebUrl($authenticityVerificationProgram, $data);

        return $authenticityVerificationProgram;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(AuthenticityVerificationProgram $authenticityVerificationProgram, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $authenticityVerificationProgram->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTermsWebUrl(AuthenticityVerificationProgram $authenticityVerificationProgram, array $data): void
    {
        if (empty($data[self::KEY_TERMS_WEB_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_TERMS_WEB_URL])) {
            return;
        }
        $authenticityVerificationProgram->setTermsWebUrl($data[self::KEY_TERMS_WEB_URL]);
    }
}

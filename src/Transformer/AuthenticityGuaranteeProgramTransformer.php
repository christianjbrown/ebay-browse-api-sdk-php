<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\AuthenticityGuaranteeProgram;
use ChristianBrown\EBay\Browse\Model\AuthenticityGuaranteeProgramInterface;

use function is_string;

final class AuthenticityGuaranteeProgramTransformer implements AuthenticityGuaranteeProgramTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AuthenticityGuaranteeProgramInterface
    {
        $authenticityGuaranteeProgram = new AuthenticityGuaranteeProgram();

        self::applyDescription($authenticityGuaranteeProgram, $data);
        self::applyTermsWebUrl($authenticityGuaranteeProgram, $data);

        return $authenticityGuaranteeProgram;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(AuthenticityGuaranteeProgram $authenticityGuaranteeProgram, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $authenticityGuaranteeProgram->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTermsWebUrl(AuthenticityGuaranteeProgram $authenticityGuaranteeProgram, array $data): void
    {
        if (empty($data[self::KEY_TERMS_WEB_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_TERMS_WEB_URL])) {
            return;
        }
        $authenticityGuaranteeProgram->setTermsWebUrl($data[self::KEY_TERMS_WEB_URL]);
    }
}

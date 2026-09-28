<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\AuthenticityGuaranteeProgramInterface;

interface AuthenticityGuaranteeProgramTransformerInterface
{
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_TERMS_WEB_URL = 'termsWebUrl';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AuthenticityGuaranteeProgramInterface;
}

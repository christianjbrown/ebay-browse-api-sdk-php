<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\CompatibilityResponseInterface;

interface CompatibilityResponseTransformerInterface
{
    public const string KEY_COMPATIBILITY_STATUS = 'compatibilityStatus';
    public const string KEY_WARNINGS = 'warnings';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CompatibilityResponseInterface;
}

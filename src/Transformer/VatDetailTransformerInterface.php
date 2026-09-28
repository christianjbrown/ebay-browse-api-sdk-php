<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\VatDetailInterface;

interface VatDetailTransformerInterface
{
    public const string KEY_ISSUING_COUNTRY = 'issuingCountry';
    public const string KEY_VAT_ID = 'vatId';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): VatDetailInterface;
}

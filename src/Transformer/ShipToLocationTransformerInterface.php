<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ShipToLocationInterface;

interface ShipToLocationTransformerInterface
{
    public const string KEY_COUNTRY = 'country';
    public const string KEY_POSTAL_CODE = 'postalCode';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ShipToLocationInterface;
}

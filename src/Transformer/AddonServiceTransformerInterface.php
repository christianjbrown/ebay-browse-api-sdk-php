<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\AddonServiceInterface;

interface AddonServiceTransformerInterface
{
    public const string KEY_SELECTION = 'selection';
    public const string KEY_SERVICE_FEE = 'serviceFee';
    public const string KEY_SERVICE_ID = 'serviceId';
    public const string KEY_SERVICE_TYPE = 'serviceType';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AddonServiceInterface;
}

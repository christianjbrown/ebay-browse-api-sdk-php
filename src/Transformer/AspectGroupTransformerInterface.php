<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\AspectGroupInterface;

interface AspectGroupTransformerInterface
{
    public const string KEY_ASPECTS = 'aspects';
    public const string KEY_LOCALIZED_GROUP_NAME = 'localizedGroupName';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AspectGroupInterface;
}

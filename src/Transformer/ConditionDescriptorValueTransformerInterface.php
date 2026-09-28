<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ConditionDescriptorValueInterface;

interface ConditionDescriptorValueTransformerInterface
{
    public const string KEY_ADDITIONAL_INFO = 'additionalInfo';
    public const string KEY_CONTENT = 'content';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ConditionDescriptorValueInterface;
}

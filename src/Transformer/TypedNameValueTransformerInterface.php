<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\TypedNameValueInterface;

interface TypedNameValueTransformerInterface
{
    public const string KEY_NAME = 'name';
    public const string KEY_TYPE = 'type';
    public const string KEY_VALUE = 'value';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TypedNameValueInterface;
}

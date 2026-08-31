<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\TypedNameValueInterface;

interface TypedNameValuesTransformerInterface
{
    public const string ARRAY_NAME = 'typedNameValue';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, TypedNameValueInterface>
     */
    public function transform(array $data): array;
}

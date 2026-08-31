<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

interface StringsTransformerInterface
{
    public const string ARRAY_NAME = 'string';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     *
     * @return array<int, string>
     */
    public function transform(array $data): array;
}

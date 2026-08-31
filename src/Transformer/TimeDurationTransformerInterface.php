<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\TimeDurationInterface;

interface TimeDurationTransformerInterface
{
    public const string KEY_UNIT = 'unit';
    public const string KEY_VALUE = 'value';
    public const string UNEXPECTED_INTEGER_SPRINTF = '%s not set or not an integer';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TimeDurationInterface;
}

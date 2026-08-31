<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ErrorParameterInterface;

interface ErrorParameterTransformerInterface
{
    public const string KEY_NAME = 'name';
    public const string KEY_VALUE = 'value';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ErrorParameterInterface;
}

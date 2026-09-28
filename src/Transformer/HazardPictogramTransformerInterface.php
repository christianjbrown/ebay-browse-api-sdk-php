<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\HazardPictogramInterface;

interface HazardPictogramTransformerInterface
{
    public const string KEY_PICTOGRAM_DESCRIPTION = 'pictogramDescription';
    public const string KEY_PICTOGRAM_ID = 'pictogramId';
    public const string KEY_PICTOGRAM_URL = 'pictogramUrl';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HazardPictogramInterface;
}

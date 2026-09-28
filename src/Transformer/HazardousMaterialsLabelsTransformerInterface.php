<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\HazardousMaterialsLabelsInterface;

interface HazardousMaterialsLabelsTransformerInterface
{
    public const string KEY_ADDITIONAL_INFORMATION = 'additionalInformation';
    public const string KEY_PICTOGRAMS = 'pictograms';
    public const string KEY_SIGNAL_WORD = 'signalWord';
    public const string KEY_SIGNAL_WORD_ID = 'signalWordId';
    public const string KEY_STATEMENTS = 'statements';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HazardousMaterialsLabelsInterface;
}

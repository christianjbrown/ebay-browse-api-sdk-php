<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\AspectDistributionInterface;

interface AspectDistributionTransformerInterface
{
    public const string KEY_ASPECT_VALUE_DISTRIBUTIONS = 'aspectValueDistributions';
    public const string KEY_LOCALIZED_ASPECT_NAME = 'localizedAspectName';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AspectDistributionInterface;
}

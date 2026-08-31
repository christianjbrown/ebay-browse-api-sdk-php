<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\AspectValueDistributionInterface;

interface AspectValueDistributionTransformerInterface
{
    public const string KEY_LOCALIZED_ASPECT_VALUE = 'localizedAspectValue';
    public const string KEY_MATCH_COUNT = 'matchCount';
    public const string KEY_REFINEMENT_HREF = 'refinementHref';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AspectValueDistributionInterface;
}

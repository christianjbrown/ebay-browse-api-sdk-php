<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\BuyingOptionDistributionInterface;

interface BuyingOptionDistributionTransformerInterface
{
    public const string KEY_BUYING_OPTION = 'buyingOption';
    public const string KEY_MATCH_COUNT = 'matchCount';
    public const string KEY_REFINEMENT_HREF = 'refinementHref';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BuyingOptionDistributionInterface;
}

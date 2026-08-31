<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ConditionDistributionInterface;

interface ConditionDistributionTransformerInterface
{
    public const string KEY_CONDITION = 'condition';
    public const string KEY_CONDITION_ID = 'conditionId';
    public const string KEY_MATCH_COUNT = 'matchCount';
    public const string KEY_REFINEMENT_HREF = 'refinementHref';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ConditionDistributionInterface;
}

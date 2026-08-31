<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ConditionDistribution;
use ChristianBrown\EBay\Browse\Model\ConditionDistributionInterface;

use function is_int;
use function is_string;

final class ConditionDistributionTransformer implements ConditionDistributionTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ConditionDistributionInterface
    {
        $conditionDistribution = new ConditionDistribution();

        self::applyCondition($conditionDistribution, $data);
        self::applyConditionId($conditionDistribution, $data);
        self::applyMatchCount($conditionDistribution, $data);
        self::applyRefinementHref($conditionDistribution, $data);

        return $conditionDistribution;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCondition(ConditionDistribution $conditionDistribution, array $data): void
    {
        if (empty($data[self::KEY_CONDITION])) {
            return;
        }
        if (!is_string($data[self::KEY_CONDITION])) {
            return;
        }
        $conditionDistribution->setCondition($data[self::KEY_CONDITION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConditionId(ConditionDistribution $conditionDistribution, array $data): void
    {
        if (empty($data[self::KEY_CONDITION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_CONDITION_ID])) {
            return;
        }
        $conditionDistribution->setConditionId($data[self::KEY_CONDITION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMatchCount(ConditionDistribution $conditionDistribution, array $data): void
    {
        if (!isset($data[self::KEY_MATCH_COUNT])) {
            return;
        }
        if (!is_int($data[self::KEY_MATCH_COUNT])) {
            return;
        }
        $conditionDistribution->setMatchCount($data[self::KEY_MATCH_COUNT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRefinementHref(ConditionDistribution $conditionDistribution, array $data): void
    {
        if (empty($data[self::KEY_REFINEMENT_HREF])) {
            return;
        }
        if (!is_string($data[self::KEY_REFINEMENT_HREF])) {
            return;
        }
        $conditionDistribution->setRefinementHref($data[self::KEY_REFINEMENT_HREF]);
    }
}

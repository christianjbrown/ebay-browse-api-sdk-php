<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\AspectValueDistribution;
use ChristianBrown\EBay\Browse\Model\AspectValueDistributionInterface;

use function is_int;
use function is_string;

final class AspectValueDistributionTransformer implements AspectValueDistributionTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AspectValueDistributionInterface
    {
        $aspectValueDistribution = new AspectValueDistribution();

        self::applyLocalizedAspectValue($aspectValueDistribution, $data);
        self::applyMatchCount($aspectValueDistribution, $data);
        self::applyRefinementHref($aspectValueDistribution, $data);

        return $aspectValueDistribution;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocalizedAspectValue(AspectValueDistribution $aspectValueDistribution, array $data): void
    {
        if (empty($data[self::KEY_LOCALIZED_ASPECT_VALUE])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCALIZED_ASPECT_VALUE])) {
            return;
        }
        $aspectValueDistribution->setLocalizedAspectValue($data[self::KEY_LOCALIZED_ASPECT_VALUE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMatchCount(AspectValueDistribution $aspectValueDistribution, array $data): void
    {
        if (!isset($data[self::KEY_MATCH_COUNT])) {
            return;
        }
        if (!is_int($data[self::KEY_MATCH_COUNT])) {
            return;
        }
        $aspectValueDistribution->setMatchCount($data[self::KEY_MATCH_COUNT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRefinementHref(AspectValueDistribution $aspectValueDistribution, array $data): void
    {
        if (empty($data[self::KEY_REFINEMENT_HREF])) {
            return;
        }
        if (!is_string($data[self::KEY_REFINEMENT_HREF])) {
            return;
        }
        $aspectValueDistribution->setRefinementHref($data[self::KEY_REFINEMENT_HREF]);
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\AspectDistribution;
use ChristianBrown\EBay\Browse\Model\AspectDistributionInterface;

use function is_array;
use function is_string;

final class AspectDistributionTransformer implements AspectDistributionTransformerInterface
{
    private AspectValueDistributionsTransformerInterface $aspectValueDistributionsTransformer;

    public function __construct(AspectValueDistributionsTransformerInterface $aspectValueDistributionsTransformer)
    {
        $this->aspectValueDistributionsTransformer = $aspectValueDistributionsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AspectDistributionInterface
    {
        $aspectDistribution = new AspectDistribution();

        $this->applyAspectValueDistributions($aspectDistribution, $data);
        self::applyLocalizedAspectName($aspectDistribution, $data);

        return $aspectDistribution;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAspectValueDistributions(AspectDistribution $aspectDistribution, array $data): void
    {
        if (empty($data[self::KEY_ASPECT_VALUE_DISTRIBUTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_ASPECT_VALUE_DISTRIBUTIONS])) {
            return;
        }
        $aspectDistribution->setAspectValueDistributions($this->aspectValueDistributionsTransformer->transform($data[self::KEY_ASPECT_VALUE_DISTRIBUTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocalizedAspectName(AspectDistribution $aspectDistribution, array $data): void
    {
        if (empty($data[self::KEY_LOCALIZED_ASPECT_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCALIZED_ASPECT_NAME])) {
            return;
        }
        $aspectDistribution->setLocalizedAspectName($data[self::KEY_LOCALIZED_ASPECT_NAME]);
    }
}

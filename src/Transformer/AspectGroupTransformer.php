<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\AspectGroup;
use ChristianBrown\EBay\Browse\Model\AspectGroupInterface;

use function is_array;
use function is_string;

final class AspectGroupTransformer implements AspectGroupTransformerInterface
{
    private AspectsTransformerInterface $aspectsTransformer;

    public function __construct(AspectsTransformerInterface $aspectsTransformer)
    {
        $this->aspectsTransformer = $aspectsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AspectGroupInterface
    {
        $aspectGroup = new AspectGroup();

        $this->applyAspects($aspectGroup, $data);
        self::applyLocalizedGroupName($aspectGroup, $data);

        return $aspectGroup;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAspects(AspectGroup $aspectGroup, array $data): void
    {
        if (empty($data[self::KEY_ASPECTS])) {
            return;
        }
        if (!is_array($data[self::KEY_ASPECTS])) {
            return;
        }
        $aspectGroup->setAspects($this->aspectsTransformer->transform($data[self::KEY_ASPECTS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocalizedGroupName(AspectGroup $aspectGroup, array $data): void
    {
        if (empty($data[self::KEY_LOCALIZED_GROUP_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCALIZED_GROUP_NAME])) {
            return;
        }
        $aspectGroup->setLocalizedGroupName($data[self::KEY_LOCALIZED_GROUP_NAME]);
    }
}

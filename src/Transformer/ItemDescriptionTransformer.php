<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\Item;

use function is_array;
use function is_bool;
use function is_int;
use function is_string;

final class ItemDescriptionTransformer implements ItemDescriptionTransformerInterface
{
    private TypedNameValuesTransformerInterface $typedNameValuesTransformer;

    public function __construct(TypedNameValuesTransformerInterface $typedNameValuesTransformer)
    {
        $this->typedNameValuesTransformer = $typedNameValuesTransformer;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    public function apply(Item $item, array $data): void
    {
        self::applyAdultOnly($item, $data);
        self::applyAgeGroup($item, $data);
        self::applyBrand($item, $data);
        self::applyCategoryId($item, $data);
        self::applyCategoryIdPath($item, $data);
        self::applyCategoryPath($item, $data);
        self::applyColor($item, $data);
        self::applyDescription($item, $data);
        self::applyEnergyEfficiencyClass($item, $data);
        self::applyEpid($item, $data);
        self::applyGender($item, $data);
        self::applyGtin($item, $data);
        self::applyInferredEpid($item, $data);
        self::applyLegacyItemId($item, $data);
        $this->applyLocalizedAspects($item, $data);
        self::applyLotSize($item, $data);
        self::applyMaterial($item, $data);
        self::applyMpn($item, $data);
        self::applyPattern($item, $data);
        self::applyRepairScore($item, $data);
        self::applyShortDescription($item, $data);
        self::applySize($item, $data);
        self::applySizeSystem($item, $data);
        self::applySizeType($item, $data);
        self::applySubtitle($item, $data);
        self::applyTitle($item, $data);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAdultOnly(Item $item, array $data): void
    {
        if (!isset($data[ItemTransformerInterface::KEY_ADULT_ONLY])) {
            return;
        }
        if (!is_bool($data[ItemTransformerInterface::KEY_ADULT_ONLY])) {
            return;
        }
        $item->setAdultOnly($data[ItemTransformerInterface::KEY_ADULT_ONLY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAgeGroup(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_AGE_GROUP])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_AGE_GROUP])) {
            return;
        }
        $item->setAgeGroup($data[ItemTransformerInterface::KEY_AGE_GROUP]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBrand(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_BRAND])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_BRAND])) {
            return;
        }
        $item->setBrand($data[ItemTransformerInterface::KEY_BRAND]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCategoryId(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_CATEGORY_ID])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_CATEGORY_ID])) {
            return;
        }
        $item->setCategoryId($data[ItemTransformerInterface::KEY_CATEGORY_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCategoryIdPath(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_CATEGORY_ID_PATH])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_CATEGORY_ID_PATH])) {
            return;
        }
        $item->setCategoryIdPath($data[ItemTransformerInterface::KEY_CATEGORY_ID_PATH]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCategoryPath(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_CATEGORY_PATH])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_CATEGORY_PATH])) {
            return;
        }
        $item->setCategoryPath($data[ItemTransformerInterface::KEY_CATEGORY_PATH]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyColor(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_COLOR])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_COLOR])) {
            return;
        }
        $item->setColor($data[ItemTransformerInterface::KEY_COLOR]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_DESCRIPTION])) {
            return;
        }
        $item->setDescription($data[ItemTransformerInterface::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEnergyEfficiencyClass(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_ENERGY_EFFICIENCY_CLASS])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_ENERGY_EFFICIENCY_CLASS])) {
            return;
        }
        $item->setEnergyEfficiencyClass($data[ItemTransformerInterface::KEY_ENERGY_EFFICIENCY_CLASS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEpid(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_EPID])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_EPID])) {
            return;
        }
        $item->setEpid($data[ItemTransformerInterface::KEY_EPID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyGender(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_GENDER])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_GENDER])) {
            return;
        }
        $item->setGender($data[ItemTransformerInterface::KEY_GENDER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyGtin(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_GTIN])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_GTIN])) {
            return;
        }
        $item->setGtin($data[ItemTransformerInterface::KEY_GTIN]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyInferredEpid(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_INFERRED_EPID])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_INFERRED_EPID])) {
            return;
        }
        $item->setInferredEpid($data[ItemTransformerInterface::KEY_INFERRED_EPID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLegacyItemId(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_LEGACY_ITEM_ID])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_LEGACY_ITEM_ID])) {
            return;
        }
        $item->setLegacyItemId($data[ItemTransformerInterface::KEY_LEGACY_ITEM_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLocalizedAspects(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_LOCALIZED_ASPECTS])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_LOCALIZED_ASPECTS])) {
            return;
        }
        $item->setLocalizedAspects($this->typedNameValuesTransformer->transform($data[ItemTransformerInterface::KEY_LOCALIZED_ASPECTS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLotSize(Item $item, array $data): void
    {
        if (!isset($data[ItemTransformerInterface::KEY_LOT_SIZE])) {
            return;
        }
        if (!is_int($data[ItemTransformerInterface::KEY_LOT_SIZE])) {
            return;
        }
        $item->setLotSize($data[ItemTransformerInterface::KEY_LOT_SIZE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMaterial(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_MATERIAL])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_MATERIAL])) {
            return;
        }
        $item->setMaterial($data[ItemTransformerInterface::KEY_MATERIAL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMpn(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_MPN])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_MPN])) {
            return;
        }
        $item->setMpn($data[ItemTransformerInterface::KEY_MPN]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPattern(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_PATTERN])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_PATTERN])) {
            return;
        }
        $item->setPattern($data[ItemTransformerInterface::KEY_PATTERN]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRepairScore(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_REPAIR_SCORE])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_REPAIR_SCORE])) {
            return;
        }
        $item->setRepairScore($data[ItemTransformerInterface::KEY_REPAIR_SCORE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyShortDescription(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_SHORT_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_SHORT_DESCRIPTION])) {
            return;
        }
        $item->setShortDescription($data[ItemTransformerInterface::KEY_SHORT_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySize(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_SIZE])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_SIZE])) {
            return;
        }
        $item->setSize($data[ItemTransformerInterface::KEY_SIZE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySizeSystem(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_SIZE_SYSTEM])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_SIZE_SYSTEM])) {
            return;
        }
        $item->setSizeSystem($data[ItemTransformerInterface::KEY_SIZE_SYSTEM]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySizeType(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_SIZE_TYPE])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_SIZE_TYPE])) {
            return;
        }
        $item->setSizeType($data[ItemTransformerInterface::KEY_SIZE_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySubtitle(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_SUBTITLE])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_SUBTITLE])) {
            return;
        }
        $item->setSubtitle($data[ItemTransformerInterface::KEY_SUBTITLE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTitle(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_TITLE])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_TITLE])) {
            return;
        }
        $item->setTitle($data[ItemTransformerInterface::KEY_TITLE]);
    }
}

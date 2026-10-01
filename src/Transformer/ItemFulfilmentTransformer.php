<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\Item;

use function is_array;
use function is_bool;
use function is_int;

final class ItemFulfilmentTransformer implements ItemFulfilmentTransformerInterface
{
    private AddonServicesTransformerInterface $addonServicesTransformer;
    private EstimatedAvailabilitiesTransformerInterface $estimatedAvailabilitiesTransformer;
    private ItemLocationTransformerInterface $itemLocationTransformer;
    private ReturnTermsTransformerInterface $returnTermsTransformer;
    private ShippingOptionsTransformerInterface $shippingOptionsTransformer;
    private ShipToLocationsTransformerInterface $shipToLocationsTransformer;

    public function __construct(AddonServicesTransformerInterface $addonServicesTransformer, EstimatedAvailabilitiesTransformerInterface $estimatedAvailabilitiesTransformer, ItemLocationTransformerInterface $itemLocationTransformer, ReturnTermsTransformerInterface $returnTermsTransformer, ShipToLocationsTransformerInterface $shipToLocationsTransformer, ShippingOptionsTransformerInterface $shippingOptionsTransformer)
    {
        $this->addonServicesTransformer = $addonServicesTransformer;
        $this->estimatedAvailabilitiesTransformer = $estimatedAvailabilitiesTransformer;
        $this->itemLocationTransformer = $itemLocationTransformer;
        $this->returnTermsTransformer = $returnTermsTransformer;
        $this->shipToLocationsTransformer = $shipToLocationsTransformer;
        $this->shippingOptionsTransformer = $shippingOptionsTransformer;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    public function apply(Item $item, array $data): void
    {
        $this->applyAddonServices($item, $data);
        self::applyEligibleForInlineCheckout($item, $data);
        self::applyEnabledForGuestCheckout($item, $data);
        $this->applyEstimatedAvailabilities($item, $data);
        self::applyImmediatePay($item, $data);
        $this->applyItemLocation($item, $data);
        self::applyPriorityListing($item, $data);
        self::applyQuantityLimitPerBuyer($item, $data);
        $this->applyReturnTerms($item, $data);
        $this->applyShipToLocations($item, $data);
        $this->applyShippingOptions($item, $data);
        self::applyTopRatedBuyingExperience($item, $data);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAddonServices(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_ADDON_SERVICES])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_ADDON_SERVICES])) {
            return;
        }
        $item->setAddonServices($this->addonServicesTransformer->transform($data[ItemTransformerInterface::KEY_ADDON_SERVICES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEligibleForInlineCheckout(Item $item, array $data): void
    {
        if (!isset($data[ItemTransformerInterface::KEY_ELIGIBLE_FOR_INLINE_CHECKOUT])) {
            return;
        }
        if (!is_bool($data[ItemTransformerInterface::KEY_ELIGIBLE_FOR_INLINE_CHECKOUT])) {
            return;
        }
        $item->setEligibleForInlineCheckout($data[ItemTransformerInterface::KEY_ELIGIBLE_FOR_INLINE_CHECKOUT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEnabledForGuestCheckout(Item $item, array $data): void
    {
        if (!isset($data[ItemTransformerInterface::KEY_ENABLED_FOR_GUEST_CHECKOUT])) {
            return;
        }
        if (!is_bool($data[ItemTransformerInterface::KEY_ENABLED_FOR_GUEST_CHECKOUT])) {
            return;
        }
        $item->setEnabledForGuestCheckout($data[ItemTransformerInterface::KEY_ENABLED_FOR_GUEST_CHECKOUT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyEstimatedAvailabilities(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_ESTIMATED_AVAILABILITIES])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_ESTIMATED_AVAILABILITIES])) {
            return;
        }
        $item->setEstimatedAvailabilities($this->estimatedAvailabilitiesTransformer->transform($data[ItemTransformerInterface::KEY_ESTIMATED_AVAILABILITIES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyImmediatePay(Item $item, array $data): void
    {
        if (!isset($data[ItemTransformerInterface::KEY_IMMEDIATE_PAY])) {
            return;
        }
        if (!is_bool($data[ItemTransformerInterface::KEY_IMMEDIATE_PAY])) {
            return;
        }
        $item->setImmediatePay($data[ItemTransformerInterface::KEY_IMMEDIATE_PAY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyItemLocation(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_ITEM_LOCATION])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_ITEM_LOCATION])) {
            return;
        }
        $item->setItemLocation($this->itemLocationTransformer->transform($data[ItemTransformerInterface::KEY_ITEM_LOCATION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPriorityListing(Item $item, array $data): void
    {
        if (!isset($data[ItemTransformerInterface::KEY_PRIORITY_LISTING])) {
            return;
        }
        if (!is_bool($data[ItemTransformerInterface::KEY_PRIORITY_LISTING])) {
            return;
        }
        $item->setPriorityListing($data[ItemTransformerInterface::KEY_PRIORITY_LISTING]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyQuantityLimitPerBuyer(Item $item, array $data): void
    {
        if (!isset($data[ItemTransformerInterface::KEY_QUANTITY_LIMIT_PER_BUYER])) {
            return;
        }
        if (!is_int($data[ItemTransformerInterface::KEY_QUANTITY_LIMIT_PER_BUYER])) {
            return;
        }
        $item->setQuantityLimitPerBuyer($data[ItemTransformerInterface::KEY_QUANTITY_LIMIT_PER_BUYER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyReturnTerms(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_RETURN_TERMS])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_RETURN_TERMS])) {
            return;
        }
        $item->setReturnTerms($this->returnTermsTransformer->transform($data[ItemTransformerInterface::KEY_RETURN_TERMS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyShippingOptions(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_SHIPPING_OPTIONS])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_SHIPPING_OPTIONS])) {
            return;
        }
        $item->setShippingOptions($this->shippingOptionsTransformer->transform($data[ItemTransformerInterface::KEY_SHIPPING_OPTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyShipToLocations(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_SHIP_TO_LOCATIONS])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_SHIP_TO_LOCATIONS])) {
            return;
        }
        $item->setShipToLocations($this->shipToLocationsTransformer->transform($data[ItemTransformerInterface::KEY_SHIP_TO_LOCATIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTopRatedBuyingExperience(Item $item, array $data): void
    {
        if (!isset($data[ItemTransformerInterface::KEY_TOP_RATED_BUYING_EXPERIENCE])) {
            return;
        }
        if (!is_bool($data[ItemTransformerInterface::KEY_TOP_RATED_BUYING_EXPERIENCE])) {
            return;
        }
        $item->setTopRatedBuyingExperience($data[ItemTransformerInterface::KEY_TOP_RATED_BUYING_EXPERIENCE]);
    }
}

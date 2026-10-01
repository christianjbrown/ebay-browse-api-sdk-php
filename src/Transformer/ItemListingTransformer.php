<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\Item;

use function is_array;
use function is_int;
use function is_string;
use function strtotime;

final class ItemListingTransformer implements ItemListingTransformerInterface
{
    private AuthenticityGuaranteeProgramTransformerInterface $authenticityGuaranteeProgramTransformer;
    private AuthenticityVerificationProgramTransformerInterface $authenticityVerificationProgramTransformer;
    private ItemCharityTermsTransformerInterface $itemCharityTermsTransformer;
    private SellerCustomPoliciesTransformerInterface $sellerCustomPoliciesTransformer;
    private SellerTransformerInterface $sellerTransformer;
    private StringsTransformerInterface $stringsTransformer;

    public function __construct(AuthenticityGuaranteeProgramTransformerInterface $authenticityGuaranteeProgramTransformer, AuthenticityVerificationProgramTransformerInterface $authenticityVerificationProgramTransformer, ItemCharityTermsTransformerInterface $itemCharityTermsTransformer, SellerCustomPoliciesTransformerInterface $sellerCustomPoliciesTransformer, SellerTransformerInterface $sellerTransformer, StringsTransformerInterface $stringsTransformer)
    {
        $this->authenticityGuaranteeProgramTransformer = $authenticityGuaranteeProgramTransformer;
        $this->authenticityVerificationProgramTransformer = $authenticityVerificationProgramTransformer;
        $this->itemCharityTermsTransformer = $itemCharityTermsTransformer;
        $this->sellerCustomPoliciesTransformer = $sellerCustomPoliciesTransformer;
        $this->sellerTransformer = $sellerTransformer;
        $this->stringsTransformer = $stringsTransformer;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    public function apply(Item $item, array $data): void
    {
        $this->applyAuthenticityGuarantee($item, $data);
        $this->applyAuthenticityVerification($item, $data);
        $this->applyCharityTerms($item, $data);
        self::applyItemCreationDate($item, $data);
        self::applyItemEndDate($item, $data);
        self::applyListingMarketplaceId($item, $data);
        $this->applyQualifiedPrograms($item, $data);
        $this->applySeller($item, $data);
        $this->applySellerCustomPolicies($item, $data);
        self::applySellerItemRevision($item, $data);
        self::applyWatchCount($item, $data);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAuthenticityGuarantee(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_AUTHENTICITY_GUARANTEE])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_AUTHENTICITY_GUARANTEE])) {
            return;
        }
        $item->setAuthenticityGuarantee($this->authenticityGuaranteeProgramTransformer->transform($data[ItemTransformerInterface::KEY_AUTHENTICITY_GUARANTEE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAuthenticityVerification(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_AUTHENTICITY_VERIFICATION])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_AUTHENTICITY_VERIFICATION])) {
            return;
        }
        $item->setAuthenticityVerification($this->authenticityVerificationProgramTransformer->transform($data[ItemTransformerInterface::KEY_AUTHENTICITY_VERIFICATION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCharityTerms(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_CHARITY_TERMS])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_CHARITY_TERMS])) {
            return;
        }
        $item->setCharityTerms($this->itemCharityTermsTransformer->transform($data[ItemTransformerInterface::KEY_CHARITY_TERMS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemCreationDate(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_ITEM_CREATION_DATE])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_ITEM_CREATION_DATE])) {
            return;
        }
        $timestamp = strtotime($data[ItemTransformerInterface::KEY_ITEM_CREATION_DATE]);
        if (false === $timestamp) {
            return;
        }
        $item->setItemCreationDate($timestamp);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemEndDate(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_ITEM_END_DATE])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_ITEM_END_DATE])) {
            return;
        }
        $timestamp = strtotime($data[ItemTransformerInterface::KEY_ITEM_END_DATE]);
        if (false === $timestamp) {
            return;
        }
        $item->setItemEndDate($timestamp);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyListingMarketplaceId(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_LISTING_MARKETPLACE_ID])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_LISTING_MARKETPLACE_ID])) {
            return;
        }
        $item->setListingMarketplaceId($data[ItemTransformerInterface::KEY_LISTING_MARKETPLACE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyQualifiedPrograms(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_QUALIFIED_PROGRAMS])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_QUALIFIED_PROGRAMS])) {
            return;
        }
        $item->setQualifiedPrograms($this->stringsTransformer->transform($data[ItemTransformerInterface::KEY_QUALIFIED_PROGRAMS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySeller(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_SELLER])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_SELLER])) {
            return;
        }
        $item->setSeller($this->sellerTransformer->transform($data[ItemTransformerInterface::KEY_SELLER]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySellerCustomPolicies(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_SELLER_CUSTOM_POLICIES])) {
            return;
        }
        if (!is_array($data[ItemTransformerInterface::KEY_SELLER_CUSTOM_POLICIES])) {
            return;
        }
        $item->setSellerCustomPolicies($this->sellerCustomPoliciesTransformer->transform($data[ItemTransformerInterface::KEY_SELLER_CUSTOM_POLICIES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySellerItemRevision(Item $item, array $data): void
    {
        if (empty($data[ItemTransformerInterface::KEY_SELLER_ITEM_REVISION])) {
            return;
        }
        if (!is_string($data[ItemTransformerInterface::KEY_SELLER_ITEM_REVISION])) {
            return;
        }
        $item->setSellerItemRevision($data[ItemTransformerInterface::KEY_SELLER_ITEM_REVISION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyWatchCount(Item $item, array $data): void
    {
        if (!isset($data[ItemTransformerInterface::KEY_WATCH_COUNT])) {
            return;
        }
        if (!is_int($data[ItemTransformerInterface::KEY_WATCH_COUNT])) {
            return;
        }
        $item->setWatchCount($data[ItemTransformerInterface::KEY_WATCH_COUNT]);
    }
}

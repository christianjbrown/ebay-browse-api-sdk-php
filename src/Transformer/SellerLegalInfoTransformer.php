<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\SellerLegalInfo;
use ChristianBrown\EBay\Browse\Model\SellerLegalInfoInterface;

use function is_array;
use function is_string;

final class SellerLegalInfoTransformer implements SellerLegalInfoTransformerInterface
{
    private EconomicOperatorTransformerInterface $economicOperatorTransformer;
    private LegalAddressTransformerInterface $legalAddressTransformer;
    private VatDetailsTransformerInterface $vatDetailsTransformer;

    public function __construct(EconomicOperatorTransformerInterface $economicOperatorTransformer, LegalAddressTransformerInterface $legalAddressTransformer, VatDetailsTransformerInterface $vatDetailsTransformer)
    {
        $this->economicOperatorTransformer = $economicOperatorTransformer;
        $this->legalAddressTransformer = $legalAddressTransformer;
        $this->vatDetailsTransformer = $vatDetailsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SellerLegalInfoInterface
    {
        $sellerLegalInfo = new SellerLegalInfo();

        $this->applyEconomicOperator($sellerLegalInfo, $data);
        self::applyEmail($sellerLegalInfo, $data);
        self::applyFax($sellerLegalInfo, $data);
        self::applyImprint($sellerLegalInfo, $data);
        self::applyLegalContactFirstName($sellerLegalInfo, $data);
        self::applyLegalContactLastName($sellerLegalInfo, $data);
        self::applyName($sellerLegalInfo, $data);
        self::applyPhone($sellerLegalInfo, $data);
        self::applyRegistrationNumber($sellerLegalInfo, $data);
        $this->applySellerProvidedLegalAddress($sellerLegalInfo, $data);
        self::applyTermsOfService($sellerLegalInfo, $data);
        $this->applyVatDetails($sellerLegalInfo, $data);
        self::applyWeeeNumber($sellerLegalInfo, $data);

        return $sellerLegalInfo;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyEconomicOperator(SellerLegalInfo $sellerLegalInfo, array $data): void
    {
        if (empty($data[self::KEY_ECONOMIC_OPERATOR])) {
            return;
        }
        if (!is_array($data[self::KEY_ECONOMIC_OPERATOR])) {
            return;
        }
        $sellerLegalInfo->setEconomicOperator($this->economicOperatorTransformer->transform($data[self::KEY_ECONOMIC_OPERATOR]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEmail(SellerLegalInfo $sellerLegalInfo, array $data): void
    {
        if (empty($data[self::KEY_EMAIL])) {
            return;
        }
        if (!is_string($data[self::KEY_EMAIL])) {
            return;
        }
        $sellerLegalInfo->setEmail($data[self::KEY_EMAIL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFax(SellerLegalInfo $sellerLegalInfo, array $data): void
    {
        if (empty($data[self::KEY_FAX])) {
            return;
        }
        if (!is_string($data[self::KEY_FAX])) {
            return;
        }
        $sellerLegalInfo->setFax($data[self::KEY_FAX]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyImprint(SellerLegalInfo $sellerLegalInfo, array $data): void
    {
        if (empty($data[self::KEY_IMPRINT])) {
            return;
        }
        if (!is_string($data[self::KEY_IMPRINT])) {
            return;
        }
        $sellerLegalInfo->setImprint($data[self::KEY_IMPRINT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLegalContactFirstName(SellerLegalInfo $sellerLegalInfo, array $data): void
    {
        if (empty($data[self::KEY_LEGAL_CONTACT_FIRST_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_LEGAL_CONTACT_FIRST_NAME])) {
            return;
        }
        $sellerLegalInfo->setLegalContactFirstName($data[self::KEY_LEGAL_CONTACT_FIRST_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLegalContactLastName(SellerLegalInfo $sellerLegalInfo, array $data): void
    {
        if (empty($data[self::KEY_LEGAL_CONTACT_LAST_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_LEGAL_CONTACT_LAST_NAME])) {
            return;
        }
        $sellerLegalInfo->setLegalContactLastName($data[self::KEY_LEGAL_CONTACT_LAST_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(SellerLegalInfo $sellerLegalInfo, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $sellerLegalInfo->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPhone(SellerLegalInfo $sellerLegalInfo, array $data): void
    {
        if (empty($data[self::KEY_PHONE])) {
            return;
        }
        if (!is_string($data[self::KEY_PHONE])) {
            return;
        }
        $sellerLegalInfo->setPhone($data[self::KEY_PHONE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRegistrationNumber(SellerLegalInfo $sellerLegalInfo, array $data): void
    {
        if (empty($data[self::KEY_REGISTRATION_NUMBER])) {
            return;
        }
        if (!is_string($data[self::KEY_REGISTRATION_NUMBER])) {
            return;
        }
        $sellerLegalInfo->setRegistrationNumber($data[self::KEY_REGISTRATION_NUMBER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySellerProvidedLegalAddress(SellerLegalInfo $sellerLegalInfo, array $data): void
    {
        if (empty($data[self::KEY_SELLER_PROVIDED_LEGAL_ADDRESS])) {
            return;
        }
        if (!is_array($data[self::KEY_SELLER_PROVIDED_LEGAL_ADDRESS])) {
            return;
        }
        $sellerLegalInfo->setSellerProvidedLegalAddress($this->legalAddressTransformer->transform($data[self::KEY_SELLER_PROVIDED_LEGAL_ADDRESS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTermsOfService(SellerLegalInfo $sellerLegalInfo, array $data): void
    {
        if (empty($data[self::KEY_TERMS_OF_SERVICE])) {
            return;
        }
        if (!is_string($data[self::KEY_TERMS_OF_SERVICE])) {
            return;
        }
        $sellerLegalInfo->setTermsOfService($data[self::KEY_TERMS_OF_SERVICE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyVatDetails(SellerLegalInfo $sellerLegalInfo, array $data): void
    {
        if (empty($data[self::KEY_VAT_DETAILS])) {
            return;
        }
        if (!is_array($data[self::KEY_VAT_DETAILS])) {
            return;
        }
        $sellerLegalInfo->setVatDetails($this->vatDetailsTransformer->transform($data[self::KEY_VAT_DETAILS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyWeeeNumber(SellerLegalInfo $sellerLegalInfo, array $data): void
    {
        if (empty($data[self::KEY_WEEE_NUMBER])) {
            return;
        }
        if (!is_string($data[self::KEY_WEEE_NUMBER])) {
            return;
        }
        $sellerLegalInfo->setWeeeNumber($data[self::KEY_WEEE_NUMBER]);
    }
}

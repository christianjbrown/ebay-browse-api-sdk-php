<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\SellerLegalInfoInterface;

interface SellerLegalInfoTransformerInterface
{
    public const string KEY_ECONOMIC_OPERATOR = 'economicOperator';
    public const string KEY_EMAIL = 'email';
    public const string KEY_FAX = 'fax';
    public const string KEY_IMPRINT = 'imprint';
    public const string KEY_LEGAL_CONTACT_FIRST_NAME = 'legalContactFirstName';
    public const string KEY_LEGAL_CONTACT_LAST_NAME = 'legalContactLastName';
    public const string KEY_NAME = 'name';
    public const string KEY_PHONE = 'phone';
    public const string KEY_REGISTRATION_NUMBER = 'registrationNumber';
    public const string KEY_SELLER_PROVIDED_LEGAL_ADDRESS = 'sellerProvidedLegalAddress';
    public const string KEY_TERMS_OF_SERVICE = 'termsOfService';
    public const string KEY_VAT_DETAILS = 'vatDetails';
    public const string KEY_WEEE_NUMBER = 'weeeNumber';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SellerLegalInfoInterface;
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ItemCharityTermsInterface;

interface ItemCharityTermsTransformerInterface
{
    public const string KEY_CHARITY_ORG_ID = 'charityOrgId';
    public const string KEY_DONATION_PERCENTAGE = 'donationPercentage';
    public const string KEY_LOGO_IMAGE = 'LogoImage';
    public const string KEY_NAME = 'name';
    public const string KEY_WEBSITE = 'website';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ItemCharityTermsInterface;
}

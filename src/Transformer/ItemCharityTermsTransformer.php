<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ItemCharityTerms;
use ChristianBrown\EBay\Browse\Model\ItemCharityTermsInterface;

use function is_array;
use function is_float;
use function is_int;
use function is_string;

final class ItemCharityTermsTransformer implements ItemCharityTermsTransformerInterface
{
    private ImageTransformerInterface $imageTransformer;

    public function __construct(ImageTransformerInterface $imageTransformer)
    {
        $this->imageTransformer = $imageTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ItemCharityTermsInterface
    {
        $itemCharityTerms = new ItemCharityTerms();

        self::applyCharityOrgId($itemCharityTerms, $data);
        self::applyDonationPercentage($itemCharityTerms, $data);
        $this->applyLogoImage($itemCharityTerms, $data);
        self::applyName($itemCharityTerms, $data);
        self::applyWebsite($itemCharityTerms, $data);

        return $itemCharityTerms;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCharityOrgId(ItemCharityTerms $itemCharityTerms, array $data): void
    {
        if (empty($data[self::KEY_CHARITY_ORG_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_CHARITY_ORG_ID])) {
            return;
        }
        $itemCharityTerms->setCharityOrgId($data[self::KEY_CHARITY_ORG_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDonationPercentage(ItemCharityTerms $itemCharityTerms, array $data): void
    {
        if (!isset($data[self::KEY_DONATION_PERCENTAGE])) {
            return;
        }
        if (is_float($data[self::KEY_DONATION_PERCENTAGE])) {
            $itemCharityTerms->setDonationPercentage($data[self::KEY_DONATION_PERCENTAGE]);

            return;
        }
        if (is_int($data[self::KEY_DONATION_PERCENTAGE])) {
            $itemCharityTerms->setDonationPercentage((float) $data[self::KEY_DONATION_PERCENTAGE]);
        }
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLogoImage(ItemCharityTerms $itemCharityTerms, array $data): void
    {
        if (empty($data[self::KEY_LOGO_IMAGE])) {
            return;
        }
        if (!is_array($data[self::KEY_LOGO_IMAGE])) {
            return;
        }
        $itemCharityTerms->setLogoImage($this->imageTransformer->transform($data[self::KEY_LOGO_IMAGE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(ItemCharityTerms $itemCharityTerms, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $itemCharityTerms->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyWebsite(ItemCharityTerms $itemCharityTerms, array $data): void
    {
        if (empty($data[self::KEY_WEBSITE])) {
            return;
        }
        if (!is_string($data[self::KEY_WEBSITE])) {
            return;
        }
        $itemCharityTerms->setWebsite($data[self::KEY_WEBSITE]);
    }
}

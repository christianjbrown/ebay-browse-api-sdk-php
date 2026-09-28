<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\VatDetail;
use ChristianBrown\EBay\Browse\Model\VatDetailInterface;

use function is_string;

final class VatDetailTransformer implements VatDetailTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): VatDetailInterface
    {
        $vatDetail = new VatDetail();

        self::applyIssuingCountry($vatDetail, $data);
        self::applyVatId($vatDetail, $data);

        return $vatDetail;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIssuingCountry(VatDetail $vatDetail, array $data): void
    {
        if (empty($data[self::KEY_ISSUING_COUNTRY])) {
            return;
        }
        if (!is_string($data[self::KEY_ISSUING_COUNTRY])) {
            return;
        }
        $vatDetail->setIssuingCountry($data[self::KEY_ISSUING_COUNTRY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVatId(VatDetail $vatDetail, array $data): void
    {
        if (empty($data[self::KEY_VAT_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_VAT_ID])) {
            return;
        }
        $vatDetail->setVatId($data[self::KEY_VAT_ID]);
    }
}

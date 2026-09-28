<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\AvailableCouponInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class AvailableCouponsTransformer implements AvailableCouponsTransformerInterface
{
    private AvailableCouponTransformerInterface $availableCouponTransformer;

    public function __construct(AvailableCouponTransformerInterface $availableCouponTransformer)
    {
        $this->availableCouponTransformer = $availableCouponTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, AvailableCouponInterface>
     */
    public function transform(array $data): array
    {
        $availableCoupons = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $availableCouponData = $values[$i];
            if (!is_array($availableCouponData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $availableCoupons[] = $this->availableCouponTransformer->transform($availableCouponData);
        }

        return $availableCoupons;
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\SellerCustomPolicyInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class SellerCustomPoliciesTransformer implements SellerCustomPoliciesTransformerInterface
{
    private SellerCustomPolicyTransformerInterface $sellerCustomPolicyTransformer;

    public function __construct(SellerCustomPolicyTransformerInterface $sellerCustomPolicyTransformer)
    {
        $this->sellerCustomPolicyTransformer = $sellerCustomPolicyTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, SellerCustomPolicyInterface>
     */
    public function transform(array $data): array
    {
        $sellerCustomPolicies = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $sellerCustomPolicyData = $values[$i];
            if (!is_array($sellerCustomPolicyData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $sellerCustomPolicies[] = $this->sellerCustomPolicyTransformer->transform($sellerCustomPolicyData);
        }

        return $sellerCustomPolicies;
    }
}

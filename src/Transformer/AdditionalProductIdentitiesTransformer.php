<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\AdditionalProductIdentityInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class AdditionalProductIdentitiesTransformer implements AdditionalProductIdentitiesTransformerInterface
{
    private AdditionalProductIdentityTransformerInterface $additionalProductIdentityTransformer;

    public function __construct(AdditionalProductIdentityTransformerInterface $additionalProductIdentityTransformer)
    {
        $this->additionalProductIdentityTransformer = $additionalProductIdentityTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, AdditionalProductIdentityInterface>
     */
    public function transform(array $data): array
    {
        $additionalProductIdentities = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $additionalProductIdentityData = $values[$i];
            if (!is_array($additionalProductIdentityData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $additionalProductIdentities[] = $this->additionalProductIdentityTransformer->transform($additionalProductIdentityData);
        }

        return $additionalProductIdentities;
    }
}

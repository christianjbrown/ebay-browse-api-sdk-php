<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\PaymentMethodBrandInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class PaymentMethodBrandsTransformer implements PaymentMethodBrandsTransformerInterface
{
    private PaymentMethodBrandTransformerInterface $paymentMethodBrandTransformer;

    public function __construct(PaymentMethodBrandTransformerInterface $paymentMethodBrandTransformer)
    {
        $this->paymentMethodBrandTransformer = $paymentMethodBrandTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, PaymentMethodBrandInterface>
     */
    public function transform(array $data): array
    {
        $paymentMethodBrands = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $paymentMethodBrandData = $values[$i];
            if (!is_array($paymentMethodBrandData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $paymentMethodBrands[] = $this->paymentMethodBrandTransformer->transform($paymentMethodBrandData);
        }

        return $paymentMethodBrands;
    }
}

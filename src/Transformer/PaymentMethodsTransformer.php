<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\PaymentMethodInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class PaymentMethodsTransformer implements PaymentMethodsTransformerInterface
{
    private PaymentMethodTransformerInterface $paymentMethodTransformer;

    public function __construct(PaymentMethodTransformerInterface $paymentMethodTransformer)
    {
        $this->paymentMethodTransformer = $paymentMethodTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, PaymentMethodInterface>
     */
    public function transform(array $data): array
    {
        $paymentMethods = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $paymentMethodData = $values[$i];
            if (!is_array($paymentMethodData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $paymentMethods[] = $this->paymentMethodTransformer->transform($paymentMethodData);
        }

        return $paymentMethods;
    }
}

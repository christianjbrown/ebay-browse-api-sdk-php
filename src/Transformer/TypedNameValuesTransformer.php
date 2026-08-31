<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\TypedNameValueInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class TypedNameValuesTransformer implements TypedNameValuesTransformerInterface
{
    private TypedNameValueTransformerInterface $typedNameValueTransformer;

    public function __construct(TypedNameValueTransformerInterface $typedNameValueTransformer)
    {
        $this->typedNameValueTransformer = $typedNameValueTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, TypedNameValueInterface>
     */
    public function transform(array $data): array
    {
        $typedNameValues = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $typedNameValueData = $values[$i];
            if (!is_array($typedNameValueData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $typedNameValues[] = $this->typedNameValueTransformer->transform($typedNameValueData);
        }

        return $typedNameValues;
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\TypedNameValue;
use ChristianBrown\EBay\Browse\Model\TypedNameValueInterface;

use function is_string;
use function sprintf;

final class TypedNameValueTransformer implements TypedNameValueTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TypedNameValueInterface
    {
        if (empty($data[self::KEY_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_NAME));
        }
        if (!is_string($data[self::KEY_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_NAME));
        }
        if (empty($data[self::KEY_VALUE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_VALUE));
        }
        if (!is_string($data[self::KEY_VALUE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_VALUE));
        }
        $typedNameValue = new TypedNameValue($data[self::KEY_NAME], $data[self::KEY_VALUE]);

        self::applyType($typedNameValue, $data);

        return $typedNameValue;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyType(TypedNameValue $typedNameValue, array $data): void
    {
        if (empty($data[self::KEY_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_TYPE])) {
            return;
        }
        $typedNameValue->setType($data[self::KEY_TYPE]);
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\TimeDuration;
use ChristianBrown\EBay\Browse\Model\TimeDurationInterface;

use function is_int;
use function is_string;
use function sprintf;

final class TimeDurationTransformer implements TimeDurationTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TimeDurationInterface
    {
        if (empty($data[self::KEY_UNIT])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_UNIT));
        }
        if (!is_string($data[self::KEY_UNIT])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_UNIT));
        }
        if (!isset($data[self::KEY_VALUE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_INTEGER_SPRINTF, self::KEY_VALUE));
        }
        if (!is_int($data[self::KEY_VALUE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_INTEGER_SPRINTF, self::KEY_VALUE));
        }
        $timeDuration = new TimeDuration($data[self::KEY_UNIT], $data[self::KEY_VALUE]);

        return $timeDuration;
    }
}

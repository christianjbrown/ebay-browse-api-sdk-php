<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ErrorInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ErrorsTransformer implements ErrorsTransformerInterface
{
    private ErrorTransformerInterface $errorTransformer;

    public function __construct(ErrorTransformerInterface $errorTransformer)
    {
        $this->errorTransformer = $errorTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ErrorInterface>
     */
    public function transform(array $data): array
    {
        $errors = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $errorData = $values[$i];
            if (!is_array($errorData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $errors[] = $this->errorTransformer->transform($errorData);
        }

        return $errors;
    }
}

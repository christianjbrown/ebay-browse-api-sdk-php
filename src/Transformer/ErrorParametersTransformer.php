<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ErrorParameterInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ErrorParametersTransformer implements ErrorParametersTransformerInterface
{
    private ErrorParameterTransformerInterface $errorParameterTransformer;

    public function __construct(ErrorParameterTransformerInterface $errorParameterTransformer)
    {
        $this->errorParameterTransformer = $errorParameterTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ErrorParameterInterface>
     */
    public function transform(array $data): array
    {
        $errorParameters = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $errorParameterData = $values[$i];
            if (!is_array($errorParameterData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $errorParameters[] = $this->errorParameterTransformer->transform($errorParameterData);
        }

        return $errorParameters;
    }
}

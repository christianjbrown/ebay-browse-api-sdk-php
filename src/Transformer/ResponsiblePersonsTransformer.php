<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ResponsiblePersonInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ResponsiblePersonsTransformer implements ResponsiblePersonsTransformerInterface
{
    private ResponsiblePersonTransformerInterface $responsiblePersonTransformer;

    public function __construct(ResponsiblePersonTransformerInterface $responsiblePersonTransformer)
    {
        $this->responsiblePersonTransformer = $responsiblePersonTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ResponsiblePersonInterface>
     */
    public function transform(array $data): array
    {
        $responsiblePersons = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $responsiblePersonData = $values[$i];
            if (!is_array($responsiblePersonData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $responsiblePersons[] = $this->responsiblePersonTransformer->transform($responsiblePersonData);
        }

        return $responsiblePersons;
    }
}

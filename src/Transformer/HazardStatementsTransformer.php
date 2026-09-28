<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\HazardStatementInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class HazardStatementsTransformer implements HazardStatementsTransformerInterface
{
    private HazardStatementTransformerInterface $hazardStatementTransformer;

    public function __construct(HazardStatementTransformerInterface $hazardStatementTransformer)
    {
        $this->hazardStatementTransformer = $hazardStatementTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, HazardStatementInterface>
     */
    public function transform(array $data): array
    {
        $hazardStatements = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $hazardStatementData = $values[$i];
            if (!is_array($hazardStatementData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $hazardStatements[] = $this->hazardStatementTransformer->transform($hazardStatementData);
        }

        return $hazardStatements;
    }
}

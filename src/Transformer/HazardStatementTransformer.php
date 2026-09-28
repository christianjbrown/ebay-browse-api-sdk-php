<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\HazardStatement;
use ChristianBrown\EBay\Browse\Model\HazardStatementInterface;

use function is_string;

final class HazardStatementTransformer implements HazardStatementTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HazardStatementInterface
    {
        $hazardStatement = new HazardStatement();

        self::applyStatementDescription($hazardStatement, $data);
        self::applyStatementId($hazardStatement, $data);

        return $hazardStatement;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStatementDescription(HazardStatement $hazardStatement, array $data): void
    {
        if (empty($data[self::KEY_STATEMENT_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_STATEMENT_DESCRIPTION])) {
            return;
        }
        $hazardStatement->setStatementDescription($data[self::KEY_STATEMENT_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStatementId(HazardStatement $hazardStatement, array $data): void
    {
        if (empty($data[self::KEY_STATEMENT_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_STATEMENT_ID])) {
            return;
        }
        $hazardStatement->setStatementId($data[self::KEY_STATEMENT_ID]);
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\HazardStatementInterface;

interface HazardStatementTransformerInterface
{
    public const string KEY_STATEMENT_DESCRIPTION = 'statementDescription';
    public const string KEY_STATEMENT_ID = 'statementId';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HazardStatementInterface;
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\SellerInterface;

interface SellerTransformerInterface
{
    public const string KEY_FEEDBACK_PERCENTAGE = 'feedbackPercentage';
    public const string KEY_FEEDBACK_SCORE = 'feedbackScore';
    public const string KEY_SELLER_ACCOUNT_TYPE = 'sellerAccountType';
    public const string KEY_USERNAME = 'username';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SellerInterface;
}

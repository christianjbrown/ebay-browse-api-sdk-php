<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse;

use ChristianBrown\EBay\Browse\Enums\MarketplaceId;

use function array_filter;

final class Marketplace implements MarketplaceInterface
{
    private ?string $acceptLanguage;
    private ?string $endUserContext;
    private MarketplaceId $marketplaceId;

    public function __construct(MarketplaceId $marketplaceId, ?string $endUserContext = null, ?string $acceptLanguage = null)
    {
        $this->marketplaceId = $marketplaceId;
        $this->endUserContext = $endUserContext;
        $this->acceptLanguage = $acceptLanguage;
    }

    public function getAcceptLanguage(): ?string
    {
        return $this->acceptLanguage;
    }

    public function getEndUserContext(): ?string
    {
        return $this->endUserContext;
    }

    public function getMarketplaceId(): MarketplaceId
    {
        return $this->marketplaceId;
    }

    /**
     * @return array<string, string>
     */
    public function toHeaders(): array
    {
        // array_filter over a candidate map keeps this a single, branch-free
        // control-flow path however many of the optional headers are set.
        return array_filter(
            [
                self::HEADER_KEY_MARKETPLACE_ID => $this->marketplaceId->value,
                self::HEADER_KEY_END_USER_CONTEXT => $this->endUserContext,
                self::HEADER_KEY_ACCEPT_LANGUAGE => $this->acceptLanguage,
            ],
            static fn (?string $value): bool => null !== $value,
        );
    }
}

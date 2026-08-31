<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\Exception\Response\BadResponseExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\EBay\Browse\Auth\CredentialsInterface;
use ChristianBrown\EBay\Browse\Exception\ItemNotFoundException;
use ChristianBrown\EBay\Browse\Exception\MissingInputException;
use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\CompatibilityResponseInterface;
use ChristianBrown\EBay\Browse\Transformer\CompatibilityResponseTransformerInterface;
use Throwable;

use function array_keys;
use function array_map;
use function array_values;
use function rawurlencode;
use function sprintf;

final class ItemCompatibilityApi implements ItemCompatibilityApiInterface
{
    private CompatibilityResponseTransformerInterface $compatibilityResponseTransformer;
    private CredentialsInterface $credentials;
    private JsonApiRequestSenderInterface $requestSender;

    public function __construct(JsonApiRequestSenderInterface $requestSender, CompatibilityResponseTransformerInterface $compatibilityResponseTransformer, CredentialsInterface $credentials)
    {
        $this->requestSender = $requestSender;
        $this->compatibilityResponseTransformer = $compatibilityResponseTransformer;
        $this->credentials = $credentials;
    }

    /**
     * @param string                $itemId                  The Browse API item id, e.g. `v1|203846989875|0`
     * @param array<string, string> $compatibilityProperties Aspect name => value, e.g. `['Year' => '2016', 'Make' => 'Honda']`
     *
     * @throws ItemNotFoundException
     * @throws MissingInputException
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function check(string $itemId, array $compatibilityProperties): CompatibilityResponseInterface
    {
        if (empty($compatibilityProperties)) {
            throw new MissingInputException(self::MISSING_COMPATIBILITY_PROPERTIES);
        }

        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($itemId));
        $body = [self::KEY_COMPATIBILITY_PROPERTIES => self::buildProperties($compatibilityProperties)];

        try {
            $data = $this->requestSender->post($url, [], $this->credentials->toHeaders(), $body);
        } catch (BadResponseExceptionInterface $exception) {
            throw self::mapNotFound($exception, $itemId);
        }

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }

        return $this->compatibilityResponseTransformer->transform($data);
    }

    /**
     * @param array<string, string> $compatibilityProperties
     *
     * @return array<int, array<string, string>>
     */
    private static function buildProperties(array $compatibilityProperties): array
    {
        // array_map over the keys and values keeps this branch-free; a fixed-size
        // loop would add a "loop not entered" path that an already-guarded,
        // never-empty map can never reach.
        return array_map(
            static fn (string $name, string $value): array => [
                self::KEY_NAME => $name,
                self::KEY_VALUE => $value,
            ],
            array_keys($compatibilityProperties),
            array_values($compatibilityProperties),
        );
    }

    private static function mapNotFound(BadResponseExceptionInterface $exception, string $itemId): Throwable
    {
        if (self::HTTP_STATUS_NOT_FOUND !== $exception->getResponse()->getStatusCode()) {
            return $exception;
        }

        return new ItemNotFoundException(sprintf(self::ITEM_NOT_FOUND_SPRINTF, $itemId), 0, $exception);
    }
}

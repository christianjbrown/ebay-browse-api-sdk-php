<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Transformer;

use Psr\Http\Message\ResponseInterface;

final class JsonEndpointBadResponseTransformer implements JsonEndpointBadResponseTransformerInterface
{
    public function getFriendlyErrorFromBadResponse(ResponseInterface $response): string
    {
        $statusCode = $response->getStatusCode();
        $message = sprintf(self::MESSAGE_GENERIC, $statusCode, self::FRIENDLY_NAME, $response->getBody());

        return $message;
    }

    public function getFriendlyErrorFromBadResponseJsonData(ResponseInterface $response, array $responseData): string
    {
        if (empty($responseData[self::ERROR_DESCRIPTION_KEY]) || !is_string($responseData[self::ERROR_DESCRIPTION_KEY])) {
            $message = $this->getFriendlyErrorFromBadResponse($response);
        } else {
            $message = sprintf(self::MESSAGE_FROM_ERROR_DESCRIPTION, $response->getStatusCode(), self::FRIENDLY_NAME, $responseData[self::ERROR_DESCRIPTION_KEY]);
        }

        return $message;
    }
}

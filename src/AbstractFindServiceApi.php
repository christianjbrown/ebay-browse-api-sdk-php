<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi;

use ChristianBrown\eBay\FindServiceApi\Model\ResultSet;
use ChristianBrown\eBay\FindServiceApi\Transformer\DatasTransformerInterface;
use ChristianBrown\eBay\FindServiceApi\Transformer\JsonEndpointBadResponseTransformer;
use ChristianBrown\eBay\FindServiceApi\Transformer\ResultSetTransformer;
use ChristianBrown\JsonApiClient\RequestSender;
use ChristianBrown\UserFriendlyException\UserFriendlyException;

abstract class AbstractFindServiceApi implements FindServiceApiInterface
{
    private string $clientId;
    private RequestSender $jsonEndpointRequestSender;
    private ResultSetTransformer $resultSetTransformer;

    public function __construct(string $clientId)
    {
        $this->clientId = $clientId;
        $this->resultSetTransformer = new ResultSetTransformer();
        $jsonEndpointErrorResponseParser = new JsonEndpointBadResponseTransformer();
        $this->jsonEndpointRequestSender = new RequestSender($jsonEndpointErrorResponseParser);
    }

    final protected function getMultiple(array $params, string $operationName, DatasTransformerInterface $datasTransformer): ResultSet
    {
        $params[self::API_KEY_RESPONSE_DATA_FORMAT] = self::API_VALUE_RESPONSE_DATA_FORMAT_JSON;
        $params[self::API_KEY_SECURITY_APP_NAME] = $this->clientId;
        $params[self::API_KEY_OPERATION_NAME] = $operationName;

        $data = $this->jsonEndpointRequestSender->get(self::FRIENDLY_NAME, self::URL, $params);

        $topLevelName = self::getTopLevelNode($operationName);
        if (empty($data[$topLevelName][0]) || !is_array($data[$topLevelName][0])) {
            throw new UserFriendlyException(sprintf('Response from %s %s was not as expected.', self::FRIENDLY_NAME, $operationName));
        }
        $unwrappedData = $data[$topLevelName][0];

        if (empty($unwrappedData[self::DATA_KEY_ACK]) || self::DATA_VALUE_ACK_SUCCESS !== $unwrappedData[self::DATA_KEY_ACK]) {
            throw new UserFriendlyException(sprintf('Response from %s %s was not successful.', self::FRIENDLY_NAME, $operationName));
        }

        return $this->resultSetTransformer->transform($unwrappedData, $datasTransformer);
    }

    private static function getTopLevelNode(string $operationName): string
    {
        return sprintf('%sResponse', $operationName);
    }
}

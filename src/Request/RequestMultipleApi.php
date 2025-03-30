<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Request;

use ChristianBrown\eBay\FindServiceApi\Model\ResultSet;
use ChristianBrown\eBay\FindServiceApi\Model\ResultSetInterface;
use ChristianBrown\eBay\FindServiceApi\Transformer\ObjectsTransformerInterface;
use ChristianBrown\eBay\FindServiceApi\Transformer\PaginationTransformerInterface;
use ChristianBrown\JsonApiClient\JsonApiRequestExceptionInterface;
use ChristianBrown\JsonApiClient\JsonApiRequestSenderInterface;
use InvalidArgumentException;

use function is_array;
use function sprintf;

final class RequestMultipleApi implements RequestMultipleApiInterface
{
    private string $clientId;
    private PaginationTransformerInterface $paginationTransformer;
    private JsonApiRequestSenderInterface $requestSender;

    public function __construct(JsonApiRequestSenderInterface $requestSender, PaginationTransformerInterface $paginationTransformer, string $clientId)
    {
        $this->requestSender = $requestSender;
        $this->paginationTransformer = $paginationTransformer;
        $this->clientId = $clientId;
    }

    /**
     * @throws JsonApiRequestExceptionInterface
     */
    public function getMultiple(ObjectsTransformerInterface $objectsTransformer, string $operationName, array $params = []): ResultSetInterface
    {
        $params[self::API_KEY_RESPONSE_DATA_FORMAT] = self::API_VALUE_RESPONSE_DATA_FORMAT_JSON;
        $params[self::API_KEY_SECURITY_APP_NAME] = $this->clientId;
        $params[self::API_KEY_OPERATION_NAME] = $operationName;

        $data = $this->requestSender->get(self::URL, $params);

        $topLevelName = sprintf('%sResponse', $operationName);
        if (empty($data[$topLevelName][0]) || !is_array($data[$topLevelName][0])) {
            throw new InvalidArgumentException(sprintf('Response from %s %s was not as expected.', self::FRIENDLY_NAME, $operationName));
        }
        $unwrappedData = $data[$topLevelName][0];

        if (empty($unwrappedData[self::DATA_KEY_ACK]) || self::DATA_VALUE_ACK_SUCCESS !== $unwrappedData[self::DATA_KEY_ACK]) {
            throw new InvalidArgumentException(sprintf('Response from %s %s was not successful.', self::FRIENDLY_NAME, $operationName));
        }

        if (!isset($unwrappedData[self::DATA_KEY_SEARCH_RESULT][0]) || !is_array($unwrappedData[self::DATA_KEY_SEARCH_RESULT][0])) {
            throw new InvalidArgumentException(sprintf('Search result array from %s %s is unexpected', self::FRIENDLY_NAME, $operationName));
        }
        $searchResult = $unwrappedData[self::DATA_KEY_SEARCH_RESULT][0];

        // @todo We only know results are under 'item' for FindItemsAdvanced, but not sure about other APIs yet.
        if (!isset($searchResult[self::DATA_KEY_SEARCH_RESULT_0_ITEM]) || !is_array($searchResult[self::DATA_KEY_SEARCH_RESULT_0_ITEM])) {
            throw new InvalidArgumentException(sprintf('Search result item array from %s %s is unexpected', self::FRIENDLY_NAME, $operationName));
        }
        $objectsData = $searchResult[self::DATA_KEY_SEARCH_RESULT_0_ITEM];

        if (!isset($unwrappedData[self::DATA_KEY_PAGINATION][0]) || !is_array($unwrappedData[self::DATA_KEY_PAGINATION][0])) {
            throw new InvalidArgumentException(sprintf('Search result pagination from %s %s is unexpected', self::FRIENDLY_NAME, $operationName));
        }
        $paginationData = $unwrappedData[self::DATA_KEY_PAGINATION][0];

        $pagination = $this->paginationTransformer->transform($paginationData);
        $objects = $objectsTransformer->transform($objectsData);
        $resultSet = new ResultSet($pagination, $objects);

        return $resultSet;
    }
}

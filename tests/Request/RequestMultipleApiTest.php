<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Tests\Request;

use ChristianBrown\eBay\FindServiceApi\Model\PaginationInterface;
use ChristianBrown\eBay\FindServiceApi\Model\ResultSet;
use ChristianBrown\eBay\FindServiceApi\Request\ApiInterface;
use ChristianBrown\eBay\FindServiceApi\Request\RequestMultipleApi;
use ChristianBrown\eBay\FindServiceApi\Request\RequestMultipleApiInterface;
use ChristianBrown\eBay\FindServiceApi\Transformer\ObjectsTransformerInterface;
use ChristianBrown\eBay\FindServiceApi\Transformer\PaginationTransformerInterface;
use ChristianBrown\JsonApiClient\JsonApiRequestExceptionInterface;
use ChristianBrown\JsonApiClient\JsonApiRequestSenderInterface;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use stdClass;

use function sprintf;

#[CoversClass(ResultSet::class)]
#[CoversClass(RequestMultipleApi::class)]
final class RequestMultipleApiTest extends TestCase
{
    public static function dataProviderTestTransformInvalid(): array
    {
        $testCases = [];
        $baseData = [
            'test-operation-nameResponse' => [
                [
                    ApiInterface::DATA_KEY_ACK => ApiInterface::DATA_VALUE_ACK_SUCCESS,
                    RequestMultipleApiInterface::DATA_KEY_SEARCH_RESULT => [
                        [
                            RequestMultipleApiInterface::DATA_KEY_SEARCH_RESULT_0_ITEM => [['data-item-1'], ['data-item-2']],
                        ],
                    ],
                    RequestMultipleApiInterface::DATA_KEY_PAGINATION => [
                        ['data-pagination'],
                    ],
                ],
            ],
        ];

        $testCases[] = [[], sprintf('Response from %s %s was not as expected.', ApiInterface::FRIENDLY_NAME, 'test-operation-name')];
        $testCases[] = [['test-operation-nameResponse' => ['x']], sprintf('Response from %s %s was not as expected.', ApiInterface::FRIENDLY_NAME, 'test-operation-name')];

        $testCaseMissingAck = $baseData;
        unset($testCaseMissingAck['test-operation-nameResponse'][0][ApiInterface::DATA_KEY_ACK]);
        $testCases[] = [$testCaseMissingAck, sprintf('Response from %s %s was not successful.', ApiInterface::FRIENDLY_NAME, 'test-operation-name')];

        $testCaseAckNotSuccess = $baseData;
        $testCaseAckNotSuccess['test-operation-nameResponse'][0][ApiInterface::DATA_KEY_ACK] = 'test-not-success';
        $testCases[] = [$testCaseAckNotSuccess, sprintf('Response from %s %s was not successful.', ApiInterface::FRIENDLY_NAME, 'test-operation-name')];

        $testCaseMissingSearchResult = $baseData;
        unset($testCaseMissingSearchResult['test-operation-nameResponse'][0][RequestMultipleApiInterface::DATA_KEY_SEARCH_RESULT]);
        $testCases[] = [$testCaseMissingSearchResult, sprintf('Search result array from %s %s is unexpected', ApiInterface::FRIENDLY_NAME, 'test-operation-name')];

        $testCaseSearchResultNotArray = $baseData;
        $testCaseSearchResultNotArray['test-operation-nameResponse'][0][RequestMultipleApiInterface::DATA_KEY_SEARCH_RESULT][0] = 42;
        $testCases[] = [$testCaseSearchResultNotArray, sprintf('Search result array from %s %s is unexpected', ApiInterface::FRIENDLY_NAME, 'test-operation-name')];

        $testCaseSearchResultMissingItem = $baseData;
        unset($testCaseSearchResultMissingItem['test-operation-nameResponse'][0][RequestMultipleApiInterface::DATA_KEY_SEARCH_RESULT][0][RequestMultipleApiInterface::DATA_KEY_SEARCH_RESULT_0_ITEM]);
        $testCases[] = [$testCaseSearchResultMissingItem, sprintf('Search result item array from %s %s is unexpected', ApiInterface::FRIENDLY_NAME, 'test-operation-name')];

        $testCasePaginationNotArray = $baseData;
        $testCasePaginationNotArray['test-operation-nameResponse'][0][RequestMultipleApiInterface::DATA_KEY_PAGINATION][0] = 42;
        $testCases[] = [$testCasePaginationNotArray, sprintf('Search result pagination from %s %s is unexpected', ApiInterface::FRIENDLY_NAME, 'test-operation-name')];

        $testCaseMissingPagination = $baseData;
        unset($testCaseMissingPagination['test-operation-nameResponse'][0][RequestMultipleApiInterface::DATA_KEY_PAGINATION]);
        $testCases[] = [$testCaseMissingPagination, sprintf('Search result pagination from %s %s is unexpected', ApiInterface::FRIENDLY_NAME, 'test-operation-name')];

        return $testCases;
    }

    /**
     * @throws Exception
     * @throws JsonApiRequestExceptionInterface
     */
    public function testTransform(): void
    {
        $resultObj1 = $this->createMock(stdClass::class);
        $resultObj2 = $this->createMock(stdClass::class);
        $objects = [$resultObj1, $resultObj2];

        $dataItems = [['data-item-1'], ['data-item-2']];
        $data = [
            'test-operation-nameResponse' => [
                [
                    ApiInterface::DATA_KEY_ACK => ApiInterface::DATA_VALUE_ACK_SUCCESS,
                    RequestMultipleApiInterface::DATA_KEY_SEARCH_RESULT => [
                        [
                            RequestMultipleApiInterface::DATA_KEY_SEARCH_RESULT_0_ITEM => $dataItems,
                        ],
                    ],
                    RequestMultipleApiInterface::DATA_KEY_PAGINATION => [
                        ['data-pagination'],
                    ],
                ],
            ],
        ];

        $objectsTransformer = $this->createMock(ObjectsTransformerInterface::class);
        $objectsTransformer->method('transform')
            ->with($dataItems)
            ->willReturn($objects);

        $pagination = $this->createMock(PaginationInterface::class);

        $paginationTransformer = $this->createMock(PaginationTransformerInterface::class);
        $paginationTransformer->method('transform')
            ->with(['data-pagination'])
            ->willReturn($pagination);

        $requestSender = $this->createMock(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')
            ->with(
                ApiInterface::URL,
                [
                    'test-param-1-key' => 'test-param-1-value',
                    ApiInterface::API_KEY_RESPONSE_DATA_FORMAT => ApiInterface::API_VALUE_RESPONSE_DATA_FORMAT_JSON,
                    ApiInterface::API_KEY_SECURITY_APP_NAME => 'test-client-id',
                    ApiInterface::API_KEY_OPERATION_NAME => 'test-operation-name',
                ]
            )
            ->willReturn($data);

        $transformer = new RequestMultipleApi($requestSender, $paginationTransformer, 'test-client-id');
        $actual = $transformer->getMultiple($objectsTransformer, 'test-operation-name', ['test-param-1-key' => 'test-param-1-value']);

        self::assertSame($objects, $actual->getObjects());
        self::assertSame($pagination, $actual->getPagination());
    }

    /**
     * @throws JsonApiRequestExceptionInterface
     * @throws Exception
     */
    #[DataProvider('dataProviderTestTransformInvalid')]
    public function testTransformInvalid(array $data, string $expectedExceptionMessage): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $requestSender = $this->createMock(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')
            ->with(
                ApiInterface::URL,
                [
                    'test-param-1-key' => 'test-param-1-value',
                    ApiInterface::API_KEY_RESPONSE_DATA_FORMAT => ApiInterface::API_VALUE_RESPONSE_DATA_FORMAT_JSON,
                    ApiInterface::API_KEY_SECURITY_APP_NAME => 'test-client-id',
                    ApiInterface::API_KEY_OPERATION_NAME => 'test-operation-name',
                ]
            )
            ->willReturn($data);

        $paginationTransformer = $this->createMock(PaginationTransformerInterface::class);
        $objectsTransformer = $this->createMock(ObjectsTransformerInterface::class);

        $transformer = new RequestMultipleApi($requestSender, $paginationTransformer, 'test-client-id');
        $transformer->getMultiple($objectsTransformer, 'test-operation-name', ['test-param-1-key' => 'test-param-1-value']);
    }
}

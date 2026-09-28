<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Api;

use ChristianBrown\ApiClient\Exception\Response\BadResponseException;
use ChristianBrown\ApiClient\Exception\Response\BadResponseExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\EBay\Browse\Api\ItemApi;
use ChristianBrown\EBay\Browse\Api\ItemApiInterface;
use ChristianBrown\EBay\Browse\Auth\CredentialsInterface;
use ChristianBrown\EBay\Browse\Cache\ArrayKeyedCache;
use ChristianBrown\EBay\Browse\Exception\ItemNotFoundException;
use ChristianBrown\EBay\Browse\Exception\MissingInputException;
use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Http\ApiHost;
use ChristianBrown\EBay\Browse\Model\ItemGroupInterface;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use ChristianBrown\EBay\Browse\Model\ItemsResponse;
use ChristianBrown\EBay\Browse\Model\ItemsResponseInterface;
use ChristianBrown\EBay\Browse\Transformer\ErrorParametersTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorParameterTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemGroupTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemsResponseTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemsResponseTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformer;
use GuzzleHttp\Exception\BadResponseException as GuzzleBadResponseException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ItemApi::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(ArrayKeyedCache::class)]
#[UsesClass(ErrorParametersTransformer::class)]
#[UsesClass(ErrorParameterTransformer::class)]
#[UsesClass(ErrorsTransformer::class)]
#[UsesClass(ErrorTransformer::class)]
#[UsesClass(ItemsResponse::class)]
#[UsesClass(ItemsResponseTransformer::class)]
#[UsesClass(ItemsTransformer::class)]
#[UsesClass(StringsTransformer::class)]
final class ItemApiTest extends TestCase
{
    private const string ITEM_ID = 'v1|123456789012|0';
    private const string ITEM_URL = 'https://api.ebay.com/buy/browse/v1/item/v1%7C123456789012%7C0';

    public function testGetItemsDefaultWiringBuildsItsOwnTransformerAndCache(): void
    {
        $item = self::createStub(ItemInterface::class);

        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn(['items' => [['raw-item']], 'total' => 1]);

        $itemTransformer = self::createStub(ItemTransformerInterface::class);
        $itemTransformer->method('transform')->willReturn($item);

        $credentials = self::createStub(CredentialsInterface::class);
        $credentials->method('toHeaders')->willReturn(self::headers());

        /**
         * @var ArrayKeyedCache<ItemInterface> $oneCache
         */
        $oneCache = new ArrayKeyedCache();

        /**
         * @var ArrayKeyedCache<ItemInterface> $legacyCache
         */
        $legacyCache = new ArrayKeyedCache();

        /**
         * @var ArrayKeyedCache<ItemGroupInterface> $itemGroupCache
         */
        $itemGroupCache = new ArrayKeyedCache();

        // No ItemsResponseTransformerInterface or cache passed: exercises the
        // backward-compatible default the constructor builds for a caller
        // that predates getItems().
        $api = new ItemApi($requestSender, $itemTransformer, self::createStub(ItemGroupTransformerInterface::class), $credentials, ApiHost::production(), $oneCache, $legacyCache, $itemGroupCache);

        $itemsResponse = $api->getItems(['v1|1|0']);

        self::assertSame([$item], $itemsResponse->getItems());
        self::assertSame(1, $itemsResponse->getTotal());
    }

    public function testGetItemsRethrowsOtherBadResponses(): void
    {
        $exception = self::badResponse(500);

        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willThrowException($exception);

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectExceptionObject($exception);

        $api->getItems(['v1|1|0']);
    }

    public function testGetItemsReturnsCachedResponseOnSecondCall(): void
    {
        $itemsResponse = self::createStub(ItemsResponseInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['items' => []]);

        $itemsResponseTransformer = self::createStub(ItemsResponseTransformerInterface::class);
        $itemsResponseTransformer->method('transform')->willReturn($itemsResponse);

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class), $itemsResponseTransformer);

        $first = $api->getItems(['v1|1|0']);
        $second = $api->getItems(['v1|1|0']);

        self::assertSame($itemsResponse, $first);
        self::assertSame($itemsResponse, $second);
    }

    public function testGetItemsSkippingCacheThrowsOnEmptyResponse(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ItemApiInterface::UNEXPECTED_RESPONSE);

        $api->getItems(['v1|1|0'], [], null, true);
    }

    public function testGetItemsSkipsCache(): void
    {
        $itemsResponse = self::createStub(ItemsResponseInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['items' => []]);

        $itemsResponseTransformer = self::createStub(ItemsResponseTransformerInterface::class);
        $itemsResponseTransformer->method('transform')->willReturn($itemsResponse);

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class), $itemsResponseTransformer);

        $api->getItems(['v1|1|0']);
        $api->getItems(['v1|1|0'], [], null, true);
    }

    public function testGetItemsThrowsOnEmptyResponse(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ItemApiInterface::UNEXPECTED_RESPONSE);

        $api->getItems(['v1|1|0']);
    }

    public function testGetItemsThrowsWhenBothItemIdsAndItemGroupIdsProvided(): void
    {
        $api = self::buildApi(self::createStub(JsonApiRequestSenderInterface::class), self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(MissingInputException::class);
        $this->expectExceptionMessage(ItemApiInterface::BOTH_ITEM_IDS_AND_ITEM_GROUP_IDS_PROVIDED);

        $api->getItems(['v1|1|0'], ['987']);
    }

    public function testGetItemsThrowsWhenNeitherItemIdsNorItemGroupIdsProvided(): void
    {
        $api = self::buildApi(self::createStub(JsonApiRequestSenderInterface::class), self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(MissingInputException::class);
        $this->expectExceptionMessage(ItemApiInterface::NEITHER_ITEM_IDS_NOR_ITEM_GROUP_IDS_PROVIDED);

        $api->getItems();
    }

    public function testGetItemsThrowsWhenNotFound(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willThrowException(self::badResponse(ItemApiInterface::HTTP_STATUS_NOT_FOUND));

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(ItemNotFoundException::class);

        $api->getItems(['v1|1|0']);
    }

    public function testGetItemsThrowsWhenQuantityForShippingEstimateInvalid(): void
    {
        $api = self::buildApi(self::createStub(JsonApiRequestSenderInterface::class), self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(MissingInputException::class);
        $this->expectExceptionMessage(ItemApiInterface::INVALID_QUANTITY_FOR_SHIPPING_ESTIMATE);

        $api->getItems(['v1|1|0'], [], 0);
    }

    public function testGetItemsThrowsWhenTooManyItemGroupIds(): void
    {
        $api = self::buildApi(self::createStub(JsonApiRequestSenderInterface::class), self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(MissingInputException::class);
        $this->expectExceptionMessage(sprintf(ItemApiInterface::TOO_MANY_ITEM_GROUP_IDS_SPRINTF, ItemApiInterface::MAX_ITEM_GROUP_IDS));

        $api->getItems([], self::idList(ItemApiInterface::MAX_ITEM_GROUP_IDS + 1));
    }

    public function testGetItemsThrowsWhenTooManyItemIds(): void
    {
        $api = self::buildApi(self::createStub(JsonApiRequestSenderInterface::class), self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(MissingInputException::class);
        $this->expectExceptionMessage(sprintf(ItemApiInterface::TOO_MANY_ITEM_IDS_SPRINTF, ItemApiInterface::MAX_ITEM_IDS));

        $api->getItems(self::idList(ItemApiInterface::MAX_ITEM_IDS + 1));
    }

    public function testGetItemsWithItemGroupIds(): void
    {
        $itemsResponse = self::createStub(ItemsResponseInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                ItemApiInterface::API_URL_ITEMS,
                [ItemApiInterface::KEY_ITEM_GROUP_IDS => '111,222'],
                self::headers()
            )
            ->willReturn(['items' => []]);

        $itemsResponseTransformer = self::createStub(ItemsResponseTransformerInterface::class);
        $itemsResponseTransformer->method('transform')->willReturn($itemsResponse);

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class), $itemsResponseTransformer);

        self::assertSame($itemsResponse, $api->getItems([], ['111', '222']));
    }

    public function testGetItemsWithItemIds(): void
    {
        $itemsResponse = self::createStub(ItemsResponseInterface::class);

        $credentials = self::createMock(CredentialsInterface::class);
        $credentials->expects(self::once())->method('toHeaders')->with(ItemApiInterface::SCOPE_BULK)->willReturn(self::headers());

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                ItemApiInterface::API_URL_ITEMS,
                [
                    ItemApiInterface::KEY_ITEM_IDS => 'v1|1|0,v1|2|0',
                    ItemApiInterface::KEY_QUANTITY_FOR_SHIPPING_ESTIMATE => '1',
                ],
                self::headers()
            )
            ->willReturn(['items' => []]);

        $itemsResponseTransformer = self::createStub(ItemsResponseTransformerInterface::class);
        $itemsResponseTransformer->method('transform')->willReturn($itemsResponse);

        /**
         * @var ArrayKeyedCache<ItemInterface> $oneCache
         */
        $oneCache = new ArrayKeyedCache();

        /**
         * @var ArrayKeyedCache<ItemInterface> $legacyCache
         */
        $legacyCache = new ArrayKeyedCache();

        /**
         * @var ArrayKeyedCache<ItemGroupInterface> $itemGroupCache
         */
        $itemGroupCache = new ArrayKeyedCache();

        /**
         * @var ArrayKeyedCache<ItemsResponseInterface> $itemsCache
         */
        $itemsCache = new ArrayKeyedCache();

        $api = new ItemApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class), $credentials, ApiHost::production(), $oneCache, $legacyCache, $itemGroupCache, $itemsResponseTransformer, $itemsCache);

        self::assertSame($itemsResponse, $api->getItems(['v1|1|0', 'v1|2|0'], [], 1));
    }

    public function testGetMultipleByItemGroupId(): void
    {
        $itemGroup = self::createStub(ItemGroupInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                ItemApiInterface::API_URL_ITEMS_BY_ITEM_GROUP,
                [ItemApiInterface::KEY_ITEM_GROUP_ID => '987654321098'],
                self::headers()
            )
            ->willReturn(['group']);

        $itemGroupTransformer = self::createMock(ItemGroupTransformerInterface::class);
        $itemGroupTransformer->expects(self::once())->method('transform')
            ->with(['group'])
            ->willReturn($itemGroup);

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), $itemGroupTransformer);

        $first = $api->getMultipleByItemGroupId('987654321098');
        $second = $api->getMultipleByItemGroupId('987654321098');

        self::assertSame($itemGroup, $first);
        self::assertSame($itemGroup, $second);
    }

    public function testGetMultipleByItemGroupIdSkippingCacheThrowsOnEmptyResponse(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ItemApiInterface::UNEXPECTED_RESPONSE);

        $api->getMultipleByItemGroupId('987654321098', true);
    }

    public function testGetMultipleByItemGroupIdSkippingCacheThrowsWhenNotFound(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willThrowException(self::badResponse(ItemApiInterface::HTTP_STATUS_NOT_FOUND));

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(ItemNotFoundException::class);

        $api->getMultipleByItemGroupId('987654321098', true);
    }

    public function testGetMultipleByItemGroupIdSkipsCache(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['group']);

        $itemGroupTransformer = self::createStub(ItemGroupTransformerInterface::class);
        $itemGroupTransformer->method('transform')->willReturn(self::createStub(ItemGroupInterface::class));

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), $itemGroupTransformer);

        $api->getMultipleByItemGroupId('987654321098');
        $api->getMultipleByItemGroupId('987654321098', true);
    }

    public function testGetMultipleByItemGroupIdThrowsOnEmptyResponse(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ItemApiInterface::UNEXPECTED_RESPONSE);

        $api->getMultipleByItemGroupId('987654321098');
    }

    public function testGetMultipleByItemGroupIdThrowsWhenNotFound(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willThrowException(self::badResponse(ItemApiInterface::HTTP_STATUS_NOT_FOUND));

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(ItemNotFoundException::class);
        $this->expectExceptionMessage(sprintf(ItemApiInterface::ITEM_NOT_FOUND_SPRINTF, '987654321098'));

        $api->getMultipleByItemGroupId('987654321098');
    }

    public function testGetMultipleByItemGroupIdThrowsWhenQuantityForShippingEstimateInvalid(): void
    {
        $api = self::buildApi(self::createStub(JsonApiRequestSenderInterface::class), self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(MissingInputException::class);
        $this->expectExceptionMessage(ItemApiInterface::INVALID_QUANTITY_FOR_SHIPPING_ESTIMATE);

        $api->getMultipleByItemGroupId('987654321098', false, -1);
    }

    public function testGetMultipleByItemGroupIdWithQuantityForShippingEstimate(): void
    {
        $itemGroup = self::createStub(ItemGroupInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                ItemApiInterface::API_URL_ITEMS_BY_ITEM_GROUP,
                [
                    ItemApiInterface::KEY_ITEM_GROUP_ID => '987654321098',
                    ItemApiInterface::KEY_QUANTITY_FOR_SHIPPING_ESTIMATE => '2',
                ],
                self::headers()
            )
            ->willReturn(['group']);

        $itemGroupTransformer = self::createStub(ItemGroupTransformerInterface::class);
        $itemGroupTransformer->method('transform')->willReturn($itemGroup);

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), $itemGroupTransformer);

        self::assertSame($itemGroup, $api->getMultipleByItemGroupId('987654321098', false, 2));
    }

    public function testGetOneById(): void
    {
        $item = self::createStub(ItemInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(self::ITEM_URL, [], self::headers())
            ->willReturn(['item']);

        $itemTransformer = self::createMock(ItemTransformerInterface::class);
        $itemTransformer->expects(self::once())->method('transform')
            ->with(['item'])
            ->willReturn($item);

        $api = self::buildApi($requestSender, $itemTransformer, self::createStub(ItemGroupTransformerInterface::class));

        $first = $api->getOneById(self::ITEM_ID);
        $second = $api->getOneById(self::ITEM_ID);

        self::assertSame($item, $first);
        self::assertSame($item, $second);
    }

    public function testGetOneByIdRethrowsOtherBadResponses(): void
    {
        $exception = self::badResponse(500);

        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willThrowException($exception);

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectExceptionObject($exception);

        $api->getOneById(self::ITEM_ID);
    }

    public function testGetOneByIdSkippingCacheThrowsOnEmptyResponse(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ItemApiInterface::UNEXPECTED_RESPONSE);

        $api->getOneById(self::ITEM_ID, null, true);
    }

    public function testGetOneByIdSkippingCacheThrowsWhenNotFound(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willThrowException(self::badResponse(ItemApiInterface::HTTP_STATUS_NOT_FOUND));

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(ItemNotFoundException::class);

        $api->getOneById(self::ITEM_ID, null, true);
    }

    public function testGetOneByIdSkipsCache(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['item']);

        $itemTransformer = self::createStub(ItemTransformerInterface::class);
        $itemTransformer->method('transform')->willReturn(self::createStub(ItemInterface::class));

        $api = self::buildApi($requestSender, $itemTransformer, self::createStub(ItemGroupTransformerInterface::class));

        $api->getOneById(self::ITEM_ID);
        $api->getOneById(self::ITEM_ID, null, true);
    }

    public function testGetOneByIdThrowsOnEmptyResponse(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ItemApiInterface::UNEXPECTED_RESPONSE);

        $api->getOneById(self::ITEM_ID);
    }

    public function testGetOneByIdThrowsWhenNotFound(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willThrowException(self::badResponse(ItemApiInterface::HTTP_STATUS_NOT_FOUND));

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(ItemNotFoundException::class);
        $this->expectExceptionMessage(sprintf(ItemApiInterface::ITEM_NOT_FOUND_SPRINTF, self::ITEM_ID));

        $api->getOneById(self::ITEM_ID);
    }

    public function testGetOneByIdThrowsWhenQuantityForShippingEstimateInvalid(): void
    {
        $api = self::buildApi(self::createStub(JsonApiRequestSenderInterface::class), self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(MissingInputException::class);
        $this->expectExceptionMessage(ItemApiInterface::INVALID_QUANTITY_FOR_SHIPPING_ESTIMATE);

        $api->getOneById(self::ITEM_ID, null, false, 0);
    }

    public function testGetOneByIdWithFieldgroups(): void
    {
        $item = self::createStub(ItemInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(self::ITEM_URL, [ItemApiInterface::KEY_FIELDGROUPS => 'PRODUCT'], self::headers())
            ->willReturn(['item']);

        $itemTransformer = self::createStub(ItemTransformerInterface::class);
        $itemTransformer->method('transform')->willReturn($item);

        $api = self::buildApi($requestSender, $itemTransformer, self::createStub(ItemGroupTransformerInterface::class));

        self::assertSame($item, $api->getOneById(self::ITEM_ID, 'PRODUCT'));
    }

    public function testGetOneByIdWithQuantityForShippingEstimate(): void
    {
        $item = self::createStub(ItemInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(self::ITEM_URL, [ItemApiInterface::KEY_QUANTITY_FOR_SHIPPING_ESTIMATE => '3'], self::headers())
            ->willReturn(['item']);

        $itemTransformer = self::createStub(ItemTransformerInterface::class);
        $itemTransformer->method('transform')->willReturn($item);

        $api = self::buildApi($requestSender, $itemTransformer, self::createStub(ItemGroupTransformerInterface::class));

        self::assertSame($item, $api->getOneById(self::ITEM_ID, null, false, 3));
    }

    public function testGetOneByLegacyId(): void
    {
        $item = self::createStub(ItemInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                ItemApiInterface::API_URL_ITEM_BY_LEGACY_ID,
                [ItemApiInterface::KEY_LEGACY_ITEM_ID => '123456789012'],
                self::headers()
            )
            ->willReturn(['item']);

        $itemTransformer = self::createStub(ItemTransformerInterface::class);
        $itemTransformer->method('transform')->willReturn($item);

        $api = self::buildApi($requestSender, $itemTransformer, self::createStub(ItemGroupTransformerInterface::class));

        $first = $api->getOneByLegacyId('123456789012');
        $second = $api->getOneByLegacyId('123456789012');

        self::assertSame($item, $first);
        self::assertSame($item, $second);
    }

    public function testGetOneByLegacyIdSkippingCacheThrowsOnEmptyResponse(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ItemApiInterface::UNEXPECTED_RESPONSE);

        $api->getOneByLegacyId('123456789012', null, null, null, true);
    }

    public function testGetOneByLegacyIdSkippingCacheThrowsWhenNotFound(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willThrowException(self::badResponse(ItemApiInterface::HTTP_STATUS_NOT_FOUND));

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(ItemNotFoundException::class);

        $api->getOneByLegacyId('123456789012', null, null, null, true);
    }

    public function testGetOneByLegacyIdSkipsCache(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['item']);

        $itemTransformer = self::createStub(ItemTransformerInterface::class);
        $itemTransformer->method('transform')->willReturn(self::createStub(ItemInterface::class));

        $api = self::buildApi($requestSender, $itemTransformer, self::createStub(ItemGroupTransformerInterface::class));

        $api->getOneByLegacyId('123456789012');
        $api->getOneByLegacyId('123456789012', null, null, null, true);
    }

    public function testGetOneByLegacyIdThrowsOnEmptyResponse(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ItemApiInterface::UNEXPECTED_RESPONSE);

        $api->getOneByLegacyId('123456789012');
    }

    public function testGetOneByLegacyIdThrowsWhenNotFound(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willThrowException(self::badResponse(ItemApiInterface::HTTP_STATUS_NOT_FOUND));

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(ItemNotFoundException::class);
        $this->expectExceptionMessage(sprintf(ItemApiInterface::ITEM_NOT_FOUND_SPRINTF, '123456789012'));

        $api->getOneByLegacyId('123456789012');
    }

    public function testGetOneByLegacyIdWithEveryOptionalParameter(): void
    {
        $item = self::createStub(ItemInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                ItemApiInterface::API_URL_ITEM_BY_LEGACY_ID,
                [
                    ItemApiInterface::KEY_LEGACY_ITEM_ID => '123456789012',
                    ItemApiInterface::KEY_LEGACY_VARIATION_ID => '654321',
                    ItemApiInterface::KEY_LEGACY_VARIATION_SKU => 'sku-1',
                    ItemApiInterface::KEY_FIELDGROUPS => 'PRODUCT',
                ],
                self::headers()
            )
            ->willReturn(['item']);

        $itemTransformer = self::createStub(ItemTransformerInterface::class);
        $itemTransformer->method('transform')->willReturn($item);

        $api = self::buildApi($requestSender, $itemTransformer, self::createStub(ItemGroupTransformerInterface::class));

        self::assertSame($item, $api->getOneByLegacyId('123456789012', '654321', 'sku-1', 'PRODUCT'));
    }

    public function testGetOneByLegacyIdWithQuantityForShippingEstimate(): void
    {
        $item = self::createStub(ItemInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                ItemApiInterface::API_URL_ITEM_BY_LEGACY_ID,
                [
                    ItemApiInterface::KEY_LEGACY_ITEM_ID => '123456789012',
                    ItemApiInterface::KEY_QUANTITY_FOR_SHIPPING_ESTIMATE => '5',
                ],
                self::headers()
            )
            ->willReturn(['item']);

        $itemTransformer = self::createStub(ItemTransformerInterface::class);
        $itemTransformer->method('transform')->willReturn($item);

        $api = self::buildApi($requestSender, $itemTransformer, self::createStub(ItemGroupTransformerInterface::class));

        self::assertSame($item, $api->getOneByLegacyId('123456789012', null, null, null, false, 5));
    }

    private static function badResponse(int $statusCode): BadResponseExceptionInterface
    {
        $request = new Request('GET', self::ITEM_URL);
        $response = new Response($statusCode);

        return new BadResponseException($request, new GuzzleBadResponseException('test-message', $request, $response));
    }

    private static function buildApi(JsonApiRequestSenderInterface $requestSender, ItemTransformerInterface $itemTransformer, ItemGroupTransformerInterface $itemGroupTransformer, ?ItemsResponseTransformerInterface $itemsResponseTransformer = null): ItemApi
    {
        $credentials = self::createStub(CredentialsInterface::class);
        $credentials->method('toHeaders')->willReturn(self::headers());

        /**
         * @var ArrayKeyedCache<ItemInterface> $oneCache
         */
        $oneCache = new ArrayKeyedCache();

        /**
         * @var ArrayKeyedCache<ItemInterface> $legacyCache
         */
        $legacyCache = new ArrayKeyedCache();

        /**
         * @var ArrayKeyedCache<ItemGroupInterface> $itemGroupCache
         */
        $itemGroupCache = new ArrayKeyedCache();

        /**
         * @var ArrayKeyedCache<ItemsResponseInterface> $itemsCache
         */
        $itemsCache = new ArrayKeyedCache();

        return new ItemApi($requestSender, $itemTransformer, $itemGroupTransformer, $credentials, ApiHost::production(), $oneCache, $legacyCache, $itemGroupCache, $itemsResponseTransformer ?? self::createStub(ItemsResponseTransformerInterface::class), $itemsCache);
    }

    /**
     * @return array<string, string>
     */
    private static function headers(): array
    {
        return [CredentialsInterface::HEADER_KEY_AUTHORIZATION => 'Bearer test-access-token'];
    }

    /**
     * @return array<int, string>
     */
    private static function idList(int $count): array
    {
        $values = [];
        for ($i = 0; $i < $count; ++$i) {
            $values[] = (string) $i;
        }

        return $values;
    }
}

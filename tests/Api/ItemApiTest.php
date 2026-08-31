<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Api;

use ChristianBrown\ApiClient\Exception\Response\BadResponseException;
use ChristianBrown\ApiClient\Exception\Response\BadResponseExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\EBay\Browse\Api\ItemApi;
use ChristianBrown\EBay\Browse\Api\ItemApiInterface;
use ChristianBrown\EBay\Browse\Auth\CredentialsInterface;
use ChristianBrown\EBay\Browse\Exception\ItemNotFoundException;
use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ItemGroupInterface;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemGroupTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use GuzzleHttp\Exception\BadResponseException as GuzzleBadResponseException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ItemApi::class)]
final class ItemApiTest extends TestCase
{
    private const string ITEM_ID = 'v1|203846989875|0';
    private const string ITEM_URL = 'https://api.ebay.com/buy/browse/v1/item/v1%7C203846989875%7C0';

    public function testGetMultipleByItemGroupId(): void
    {
        $itemGroup = self::createStub(ItemGroupInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                ItemApiInterface::API_URL_ITEMS_BY_ITEM_GROUP,
                [ItemApiInterface::KEY_ITEM_GROUP_ID => '800318966643'],
                self::headers()
            )
            ->willReturn(['group']);

        $itemGroupTransformer = self::createMock(ItemGroupTransformerInterface::class);
        $itemGroupTransformer->expects(self::once())->method('transform')
            ->with(['group'])
            ->willReturn($itemGroup);

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), $itemGroupTransformer);

        self::assertSame($itemGroup, $api->getMultipleByItemGroupId('800318966643'));
        self::assertSame($itemGroup, $api->getMultipleByItemGroupId('800318966643'));
    }

    public function testGetMultipleByItemGroupIdSkippingCacheThrowsOnEmptyResponse(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ItemApiInterface::UNEXPECTED_RESPONSE);

        $api->getMultipleByItemGroupId('800318966643', true);
    }

    public function testGetMultipleByItemGroupIdSkippingCacheThrowsWhenNotFound(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willThrowException(self::badResponse(ItemApiInterface::HTTP_STATUS_NOT_FOUND));

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(ItemNotFoundException::class);

        $api->getMultipleByItemGroupId('800318966643', true);
    }

    public function testGetMultipleByItemGroupIdSkipsCache(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['group']);

        $itemGroupTransformer = self::createStub(ItemGroupTransformerInterface::class);
        $itemGroupTransformer->method('transform')->willReturn(self::createStub(ItemGroupInterface::class));

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), $itemGroupTransformer);

        $api->getMultipleByItemGroupId('800318966643');
        $api->getMultipleByItemGroupId('800318966643', true);
    }

    public function testGetMultipleByItemGroupIdThrowsOnEmptyResponse(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ItemApiInterface::UNEXPECTED_RESPONSE);

        $api->getMultipleByItemGroupId('800318966643');
    }

    public function testGetMultipleByItemGroupIdThrowsWhenNotFound(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willThrowException(self::badResponse(ItemApiInterface::HTTP_STATUS_NOT_FOUND));

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(ItemNotFoundException::class);
        $this->expectExceptionMessage(sprintf(ItemApiInterface::ITEM_NOT_FOUND_SPRINTF, '800318966643'));

        $api->getMultipleByItemGroupId('800318966643');
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

        self::assertSame($item, $api->getOneById(self::ITEM_ID));
        self::assertSame($item, $api->getOneById(self::ITEM_ID));
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

    public function testGetOneByLegacyId(): void
    {
        $item = self::createStub(ItemInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                ItemApiInterface::API_URL_ITEM_BY_LEGACY_ID,
                [ItemApiInterface::KEY_LEGACY_ITEM_ID => '203846989875'],
                self::headers()
            )
            ->willReturn(['item']);

        $itemTransformer = self::createStub(ItemTransformerInterface::class);
        $itemTransformer->method('transform')->willReturn($item);

        $api = self::buildApi($requestSender, $itemTransformer, self::createStub(ItemGroupTransformerInterface::class));

        self::assertSame($item, $api->getOneByLegacyId('203846989875'));
        self::assertSame($item, $api->getOneByLegacyId('203846989875'));
    }

    public function testGetOneByLegacyIdSkippingCacheThrowsOnEmptyResponse(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ItemApiInterface::UNEXPECTED_RESPONSE);

        $api->getOneByLegacyId('203846989875', null, null, null, true);
    }

    public function testGetOneByLegacyIdSkippingCacheThrowsWhenNotFound(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willThrowException(self::badResponse(ItemApiInterface::HTTP_STATUS_NOT_FOUND));

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(ItemNotFoundException::class);

        $api->getOneByLegacyId('203846989875', null, null, null, true);
    }

    public function testGetOneByLegacyIdSkipsCache(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['item']);

        $itemTransformer = self::createStub(ItemTransformerInterface::class);
        $itemTransformer->method('transform')->willReturn(self::createStub(ItemInterface::class));

        $api = self::buildApi($requestSender, $itemTransformer, self::createStub(ItemGroupTransformerInterface::class));

        $api->getOneByLegacyId('203846989875');
        $api->getOneByLegacyId('203846989875', null, null, null, true);
    }

    public function testGetOneByLegacyIdThrowsOnEmptyResponse(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ItemApiInterface::UNEXPECTED_RESPONSE);

        $api->getOneByLegacyId('203846989875');
    }

    public function testGetOneByLegacyIdThrowsWhenNotFound(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willThrowException(self::badResponse(ItemApiInterface::HTTP_STATUS_NOT_FOUND));

        $api = self::buildApi($requestSender, self::createStub(ItemTransformerInterface::class), self::createStub(ItemGroupTransformerInterface::class));

        $this->expectException(ItemNotFoundException::class);
        $this->expectExceptionMessage(sprintf(ItemApiInterface::ITEM_NOT_FOUND_SPRINTF, '203846989875'));

        $api->getOneByLegacyId('203846989875');
    }

    public function testGetOneByLegacyIdWithEveryOptionalParameter(): void
    {
        $item = self::createStub(ItemInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                ItemApiInterface::API_URL_ITEM_BY_LEGACY_ID,
                [
                    ItemApiInterface::KEY_LEGACY_ITEM_ID => '203846989875',
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

        self::assertSame($item, $api->getOneByLegacyId('203846989875', '654321', 'sku-1', 'PRODUCT'));
    }

    private static function badResponse(int $statusCode): BadResponseExceptionInterface
    {
        $request = new Request('GET', self::ITEM_URL);
        $response = new Response($statusCode);

        return new BadResponseException($request, new GuzzleBadResponseException('test-message', $request, $response));
    }

    private static function buildApi(JsonApiRequestSenderInterface $requestSender, ItemTransformerInterface $itemTransformer, ItemGroupTransformerInterface $itemGroupTransformer): ItemApi
    {
        $credentials = self::createStub(CredentialsInterface::class);
        $credentials->method('toHeaders')->willReturn(self::headers());

        return new ItemApi($requestSender, $itemTransformer, $itemGroupTransformer, $credentials);
    }

    /**
     * @return array<string, string>
     */
    private static function headers(): array
    {
        return [CredentialsInterface::HEADER_KEY_AUTHORIZATION => 'Bearer test-access-token'];
    }
}

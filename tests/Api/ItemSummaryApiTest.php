<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Api;

use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\EBay\Browse\Api\ItemSummaryApi;
use ChristianBrown\EBay\Browse\Api\ItemSummaryApiInterface;
use ChristianBrown\EBay\Browse\Auth\CredentialsInterface;
use ChristianBrown\EBay\Browse\Exception\MissingInputException;
use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Http\ApiHost;
use ChristianBrown\EBay\Browse\Model\SearchPagedCollectionInterface;
use ChristianBrown\EBay\Browse\Transformer\SearchPagedCollectionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ItemSummaryApi::class)]
#[UsesClass(ApiHost::class)]
final class ItemSummaryApiTest extends TestCase
{
    public function testSearch(): void
    {
        $collection = self::createStub(SearchPagedCollectionInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                ItemSummaryApiInterface::API_URL_SEARCH,
                [
                    ItemSummaryApiInterface::KEY_LIMIT => '50',
                    ItemSummaryApiInterface::KEY_OFFSET => '0',
                    ItemSummaryApiInterface::KEY_Q => 'vintage film camera',
                ],
                self::headers()
            )
            ->willReturn(['search']);

        $transformer = self::createMock(SearchPagedCollectionTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with(['search'])
            ->willReturn($collection);

        $api = self::buildApi($requestSender, $transformer);

        $first = $api->search('vintage film camera');
        $second = $api->search('vintage film camera');

        self::assertSame($collection, $first);
        self::assertSame($collection, $second);
    }

    public function testSearchByImage(): void
    {
        $collection = self::createStub(SearchPagedCollectionInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                ItemSummaryApiInterface::API_URL_SEARCH_BY_IMAGE,
                [
                    ItemSummaryApiInterface::KEY_LIMIT => '10',
                    ItemSummaryApiInterface::KEY_OFFSET => '20',
                    ItemSummaryApiInterface::KEY_CHARITY_IDS => '13-1788491',
                    ItemSummaryApiInterface::KEY_CATEGORY_IDS => '15230',
                    ItemSummaryApiInterface::KEY_ASPECT_FILTER => 'categoryId:15230,Format:{35mm}',
                    ItemSummaryApiInterface::KEY_FILTER => 'buyingOptions:{FIXED_PRICE}',
                    ItemSummaryApiInterface::KEY_SORT => 'price',
                    ItemSummaryApiInterface::KEY_FIELDGROUPS => 'EXTENDED',
                ],
                self::postHeaders(),
                [ItemSummaryApiInterface::KEY_IMAGE => 'dGVzdC1pbWFnZQ==']
            )
            ->willReturn(['search']);

        $transformer = self::createMock(SearchPagedCollectionTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with(['search'])
            ->willReturn($collection);

        $api = self::buildApi($requestSender, $transformer);

        $actual = $api->searchByImage(
            'dGVzdC1pbWFnZQ==',
            '13-1788491',
            '15230',
            'categoryId:15230,Format:{35mm}',
            'buyingOptions:{FIXED_PRICE}',
            'price',
            'EXTENDED',
            10,
            20
        );

        self::assertSame($collection, $actual);
    }

    public function testSearchByImageThrowsOnEmptyImage(): void
    {
        $api = self::buildApi(self::createStub(JsonApiRequestSenderInterface::class), self::createStub(SearchPagedCollectionTransformerInterface::class));

        $this->expectException(MissingInputException::class);
        $this->expectExceptionMessage(ItemSummaryApiInterface::MISSING_IMAGE);

        $api->searchByImage('');
    }

    public function testSearchByImageThrowsOnEmptyResponse(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('post')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(SearchPagedCollectionTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ItemSummaryApiInterface::UNEXPECTED_RESPONSE);

        $api->searchByImage('dGVzdC1pbWFnZQ==');
    }

    public function testSearchSkippingCacheThrowsOnEmptyResponse(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(SearchPagedCollectionTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ItemSummaryApiInterface::UNEXPECTED_RESPONSE);

        $api->search('camera', null, null, null, null, null, null, null, null, null, null, 50, 0, true);
    }

    public function testSearchSkipsCache(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['search']);

        $transformer = self::createStub(SearchPagedCollectionTransformerInterface::class);
        $transformer->method('transform')->willReturn(self::createStub(SearchPagedCollectionInterface::class));

        $api = self::buildApi($requestSender, $transformer);

        $api->search('camera');
        $api->search('camera', null, null, null, null, null, null, null, null, null, null, 50, 0, true);
    }

    public function testSearchThrowsOnEmptyResponse(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(SearchPagedCollectionTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ItemSummaryApiInterface::UNEXPECTED_RESPONSE);

        $api->search('camera');
    }

    public function testSearchWithEveryOptionalParameter(): void
    {
        $collection = self::createStub(SearchPagedCollectionInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                ItemSummaryApiInterface::API_URL_SEARCH,
                [
                    ItemSummaryApiInterface::KEY_LIMIT => '25',
                    ItemSummaryApiInterface::KEY_OFFSET => '50',
                    ItemSummaryApiInterface::KEY_Q => 'camera',
                    ItemSummaryApiInterface::KEY_GTIN => '00190198054180',
                    ItemSummaryApiInterface::KEY_CHARITY_IDS => '13-1788491',
                    ItemSummaryApiInterface::KEY_CATEGORY_IDS => '15230',
                    ItemSummaryApiInterface::KEY_EPID => '241986',
                    ItemSummaryApiInterface::KEY_ASPECT_FILTER => 'categoryId:15230,Format:{35mm}',
                    ItemSummaryApiInterface::KEY_COMPATIBILITY_FILTER => 'Year:2016;Make:Honda',
                    ItemSummaryApiInterface::KEY_FILTER => 'buyingOptions:{FIXED_PRICE}',
                    ItemSummaryApiInterface::KEY_SORT => '-price',
                    ItemSummaryApiInterface::KEY_FIELDGROUPS => 'ASPECT_REFINEMENTS',
                    ItemSummaryApiInterface::KEY_AUTO_CORRECT => ItemSummaryApiInterface::VALUE_AUTO_CORRECT_KEYWORD,
                ],
                self::headers()
            )
            ->willReturn(['search']);

        $transformer = self::createStub(SearchPagedCollectionTransformerInterface::class);
        $transformer->method('transform')->willReturn($collection);

        $api = self::buildApi($requestSender, $transformer);

        $actual = $api->search(
            'camera',
            '00190198054180',
            '13-1788491',
            '15230',
            '241986',
            'categoryId:15230,Format:{35mm}',
            'Year:2016;Make:Honda',
            'buyingOptions:{FIXED_PRICE}',
            '-price',
            'ASPECT_REFINEMENTS',
            ItemSummaryApiInterface::VALUE_AUTO_CORRECT_KEYWORD,
            25,
            50
        );

        self::assertSame($collection, $actual);
    }

    private static function buildApi(JsonApiRequestSenderInterface $requestSender, SearchPagedCollectionTransformerInterface $searchPagedCollectionTransformer): ItemSummaryApi
    {
        $credentials = self::createStub(CredentialsInterface::class);
        $credentials->method('toHeaders')->willReturn(self::headers());

        return new ItemSummaryApi($requestSender, $searchPagedCollectionTransformer, $credentials, ApiHost::production());
    }

    /**
     * @return array<string, string>
     */
    private static function headers(): array
    {
        return [CredentialsInterface::HEADER_KEY_AUTHORIZATION => 'Bearer test-access-token'];
    }

    /**
     * @return array<string, string>
     */
    private static function postHeaders(): array
    {
        return [
            CredentialsInterface::HEADER_KEY_AUTHORIZATION => 'Bearer test-access-token',
        ];
    }
}

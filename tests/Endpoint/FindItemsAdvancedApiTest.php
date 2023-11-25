<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Tests\Endpoint;

use ChristianBrown\eBay\FindServiceApi\Endpoint\FindItemsAdvancedApi;
use ChristianBrown\eBay\FindServiceApi\Endpoint\FindItemsAdvancedApiInterface;
use ChristianBrown\eBay\FindServiceApi\Model\ResultSetInterface;
use ChristianBrown\eBay\FindServiceApi\Request\ApiInterface;
use ChristianBrown\eBay\FindServiceApi\Request\RequestMultipleApiInterface;
use ChristianBrown\eBay\FindServiceApi\Transformer\ItemsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(FindItemsAdvancedApi::class)]
final class FindItemsAdvancedApiTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testGetBySeller(): void
    {
        $resultSet = $this->createMock(ResultSetInterface::class);

        $itemsTransformer = $this->createMock(ItemsTransformerInterface::class);

        $requestMultipleApi = $this->createMock(RequestMultipleApiInterface::class);
        $requestMultipleApi->method('getMultiple')
            ->with(
                $itemsTransformer,
                FindItemsAdvancedApiInterface::OPERATION,
                [
                    ApiInterface::API_KEY_ITEM_FILTER_NAME => FindItemsAdvancedApiInterface::API_VALUE_ITEM_FILTER_NAME,
                    ApiInterface::API_KEY_ITEM_FILTER_VALUE => 'test-seller-id',
                ]
            )
            ->willReturn($resultSet);

        $api = new FindItemsAdvancedApi($requestMultipleApi, $itemsTransformer);
        $actual = $api->getBySeller('test-seller-id');

        self::assertSame($resultSet, $actual);
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Api;

use ChristianBrown\ApiClient\Exception\Response\BadResponseException;
use ChristianBrown\ApiClient\Exception\Response\BadResponseExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\EBay\Browse\Api\ItemCompatibilityApi;
use ChristianBrown\EBay\Browse\Api\ItemCompatibilityApiInterface;
use ChristianBrown\EBay\Browse\Auth\CredentialsInterface;
use ChristianBrown\EBay\Browse\Exception\ItemNotFoundException;
use ChristianBrown\EBay\Browse\Exception\MissingInputException;
use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\CompatibilityResponseInterface;
use ChristianBrown\EBay\Browse\Transformer\CompatibilityResponseTransformerInterface;
use GuzzleHttp\Exception\BadResponseException as GuzzleBadResponseException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ItemCompatibilityApi::class)]
final class ItemCompatibilityApiTest extends TestCase
{
    private const string ITEM_ID = 'v1|123456789012|0';
    private const string ITEM_URL = 'https://api.ebay.com/buy/browse/v1/item/v1%7C123456789012%7C0/check_compatibility';

    public function testCheck(): void
    {
        $compatibilityResponse = self::createStub(CompatibilityResponseInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                self::ITEM_URL,
                [],
                self::postHeaders(),
                [
                    ItemCompatibilityApiInterface::KEY_COMPATIBILITY_PROPERTIES => [
                        [
                            ItemCompatibilityApiInterface::KEY_NAME => 'Year',
                            ItemCompatibilityApiInterface::KEY_VALUE => '2016',
                        ],
                        [
                            ItemCompatibilityApiInterface::KEY_NAME => 'Make',
                            ItemCompatibilityApiInterface::KEY_VALUE => 'Honda',
                        ],
                    ],
                ]
            )
            ->willReturn(['compatibility']);

        $transformer = self::createMock(CompatibilityResponseTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with(['compatibility'])
            ->willReturn($compatibilityResponse);

        $api = self::buildApi($requestSender, $transformer);

        self::assertSame($compatibilityResponse, $api->check(self::ITEM_ID, ['Year' => '2016', 'Make' => 'Honda']));
    }

    public function testCheckRethrowsOtherBadResponses(): void
    {
        $exception = self::badResponse(400);

        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('post')->willThrowException($exception);

        $api = self::buildApi($requestSender, self::createStub(CompatibilityResponseTransformerInterface::class));

        $this->expectExceptionObject($exception);

        $api->check(self::ITEM_ID, ['Year' => '2016']);
    }

    public function testCheckThrowsOnEmptyResponse(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('post')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(CompatibilityResponseTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ItemCompatibilityApiInterface::UNEXPECTED_RESPONSE);

        $api->check(self::ITEM_ID, ['Year' => '2016']);
    }

    public function testCheckThrowsWhenNoPropertiesGiven(): void
    {
        $api = self::buildApi(self::createStub(JsonApiRequestSenderInterface::class), self::createStub(CompatibilityResponseTransformerInterface::class));

        $this->expectException(MissingInputException::class);
        $this->expectExceptionMessage(ItemCompatibilityApiInterface::MISSING_COMPATIBILITY_PROPERTIES);

        $api->check(self::ITEM_ID, []);
    }

    public function testCheckThrowsWhenNotFound(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('post')->willThrowException(self::badResponse(ItemCompatibilityApiInterface::HTTP_STATUS_NOT_FOUND));

        $api = self::buildApi($requestSender, self::createStub(CompatibilityResponseTransformerInterface::class));

        $this->expectException(ItemNotFoundException::class);
        $this->expectExceptionMessage(sprintf(ItemCompatibilityApiInterface::ITEM_NOT_FOUND_SPRINTF, self::ITEM_ID));

        $api->check(self::ITEM_ID, ['Year' => '2016']);
    }

    private static function badResponse(int $statusCode): BadResponseExceptionInterface
    {
        $request = new Request('POST', self::ITEM_URL);
        $response = new Response($statusCode);

        return new BadResponseException($request, new GuzzleBadResponseException('test-message', $request, $response));
    }

    private static function buildApi(JsonApiRequestSenderInterface $requestSender, CompatibilityResponseTransformerInterface $compatibilityResponseTransformer): ItemCompatibilityApi
    {
        $credentials = self::createStub(CredentialsInterface::class);
        $credentials->method('toHeaders')->willReturn(self::headers());

        return new ItemCompatibilityApi($requestSender, $compatibilityResponseTransformer, $credentials);
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

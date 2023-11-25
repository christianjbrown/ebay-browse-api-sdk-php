<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Tests\Transformer;

use ChristianBrown\eBay\FindServiceApi\Transformer\JsonEndpointBadResponseTransformer;
use ChristianBrown\eBay\FindServiceApi\Transformer\JsonEndpointBadResponseTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

use function sprintf;

#[CoversClass(JsonEndpointBadResponseTransformer::class)]
final class JsonEndpointBadResponseTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testGetFriendlyErrorFromBadResponse(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')
            ->willReturn(42);

        $transformer = new JsonEndpointBadResponseTransformer();
        $actual = $transformer->getFriendlyErrorFromBadResponse($response);
        $expected = sprintf(JsonEndpointBadResponseTransformerInterface::MESSAGE_GENERIC, 42, JsonEndpointBadResponseTransformerInterface::FRIENDLY_NAME);

        self::assertSame($expected, $actual);
    }

    /**
     * @throws Exception
     */
    public function testGetFriendlyErrorFromBadResponseJsonData(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')
            ->willReturn(42);

        $transformer = new JsonEndpointBadResponseTransformer();
        $data = [
            JsonEndpointBadResponseTransformerInterface::ERROR_DESCRIPTION_KEY => 'test-error-description',
        ];
        $actual = $transformer->getFriendlyErrorFromBadResponseJsonData($response, $data);
        $expected = sprintf(JsonEndpointBadResponseTransformerInterface::MESSAGE_FROM_ERROR_DESCRIPTION, 42, JsonEndpointBadResponseTransformerInterface::FRIENDLY_NAME, 'test-error-description');

        self::assertSame($expected, $actual);
    }

    /**
     * @throws Exception
     */
    #[TestWith(
        [
            [],
        ],
    )]
    #[TestWith(
        [
            [
                JsonEndpointBadResponseTransformerInterface::ERROR_DESCRIPTION_KEY => 42,
            ],
        ],
    )]
    #[TestWith(
        [
            [
                JsonEndpointBadResponseTransformerInterface::ERROR_DESCRIPTION_KEY => '',
            ],
        ],
    )]
    public function testGetFriendlyErrorFromBadResponseJsonDataMissing(array $data): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')
            ->willReturn(42);

        $transformer = new JsonEndpointBadResponseTransformer();
        $actual = $transformer->getFriendlyErrorFromBadResponseJsonData($response, $data);
        $expected = sprintf(JsonEndpointBadResponseTransformerInterface::MESSAGE_GENERIC, 42, JsonEndpointBadResponseTransformerInterface::FRIENDLY_NAME);

        self::assertSame($expected, $actual);
    }
}

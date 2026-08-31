<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Auth;

use ChristianBrown\EBay\Browse\Auth\ApplicationAccessTokenTransformer;
use ChristianBrown\EBay\Browse\Auth\ApplicationAccessTokenTransformerInterface;
use ChristianBrown\OAuth2Client\Model\AccessTokenInterface;
use ChristianBrown\OAuth2Client\Model\AccessTokenType;
use ChristianBrown\OAuth2Client\Transformer\AccessTokenTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ApplicationAccessTokenTransformer::class)]
final class ApplicationAccessTokenTransformerTest extends TestCase
{
    public function testTransformLeavesAnAbsentTokenTypeAlone(): void
    {
        $data = [ApplicationAccessTokenTransformerInterface::KEY_ACCESS_TOKEN => 'test-access-token'];
        $token = self::createStub(AccessTokenInterface::class);

        $transformer = new ApplicationAccessTokenTransformer($this->buildDelegate($data, $token));

        self::assertSame($token, $transformer->transform($data));
    }

    public function testTransformLeavesAStandardTokenTypeAlone(): void
    {
        $data = [
            ApplicationAccessTokenTransformerInterface::KEY_ACCESS_TOKEN => 'test-access-token',
            ApplicationAccessTokenTransformerInterface::KEY_TOKEN_TYPE => 'Bearer',
        ];
        $token = self::createStub(AccessTokenInterface::class);

        $transformer = new ApplicationAccessTokenTransformer($this->buildDelegate($data, $token));

        self::assertSame($token, $transformer->transform($data));
    }

    public function testTransformRewritesTheApplicationAccessTokenType(): void
    {
        $data = [
            ApplicationAccessTokenTransformerInterface::KEY_ACCESS_TOKEN => 'test-access-token',
            ApplicationAccessTokenTransformerInterface::KEY_TOKEN_TYPE => ApplicationAccessTokenTransformerInterface::TOKEN_TYPE_APPLICATION_ACCESS,
        ];
        $normalised = [
            ApplicationAccessTokenTransformerInterface::KEY_ACCESS_TOKEN => 'test-access-token',
            ApplicationAccessTokenTransformerInterface::KEY_TOKEN_TYPE => AccessTokenType::BEARER->value,
        ];
        $token = self::createStub(AccessTokenInterface::class);

        $transformer = new ApplicationAccessTokenTransformer($this->buildDelegate($normalised, $token));

        self::assertSame($token, $transformer->transform($data));
    }

    /**
     * @param array<array-key, mixed> $expectedData
     */
    private function buildDelegate(array $expectedData, AccessTokenInterface $token): AccessTokenTransformerInterface
    {
        $accessTokenTransformer = self::createMock(AccessTokenTransformerInterface::class);
        $accessTokenTransformer->expects(self::once())->method('transform')
            ->with($expectedData)
            ->willReturn($token);

        return $accessTokenTransformer;
    }
}

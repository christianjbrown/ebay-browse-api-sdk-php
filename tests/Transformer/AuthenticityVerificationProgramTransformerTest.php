<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\AuthenticityVerificationProgram;
use ChristianBrown\EBay\Browse\Model\AuthenticityVerificationProgramInterface;
use ChristianBrown\EBay\Browse\Transformer\AuthenticityVerificationProgramTransformer;
use ChristianBrown\EBay\Browse\Transformer\AuthenticityVerificationProgramTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(AuthenticityVerificationProgram::class)]
#[CoversClass(AuthenticityVerificationProgramTransformer::class)]
final class AuthenticityVerificationProgramTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            AuthenticityVerificationProgramTransformerInterface::KEY_DESCRIPTION => 'v_1',
            AuthenticityVerificationProgramTransformerInterface::KEY_TERMS_WEB_URL => 'v_2',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getDescription());
        self::assertSame('v_2', $actual->getTermsWebUrl());
    }

    /**
     * @param array<string, mixed>                                    $data
     * @param Closure(AuthenticityVerificationProgramInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(AuthenticityVerificationProgramInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (AuthenticityVerificationProgramInterface $model): void {
                self::assertNull($model->getDescription());
                self::assertNull($model->getTermsWebUrl());
            },
        ];

        yield 'descriptionWrongType' => [
            [...$base, AuthenticityVerificationProgramTransformerInterface::KEY_DESCRIPTION => 42],
            static function (AuthenticityVerificationProgramInterface $model): void {
                self::assertNull($model->getDescription());
            },
        ];

        yield 'termsWebUrlWrongType' => [
            [...$base, AuthenticityVerificationProgramTransformerInterface::KEY_TERMS_WEB_URL => 42],
            static function (AuthenticityVerificationProgramInterface $model): void {
                self::assertNull($model->getTermsWebUrl());
            },
        ];
    }

    private function buildTransformer(): AuthenticityVerificationProgramTransformer
    {

        return new AuthenticityVerificationProgramTransformer();
    }
}

<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\AuthenticityGuaranteeProgram;
use ChristianBrown\EBay\Browse\Model\AuthenticityGuaranteeProgramInterface;
use ChristianBrown\EBay\Browse\Transformer\AuthenticityGuaranteeProgramTransformer;
use ChristianBrown\EBay\Browse\Transformer\AuthenticityGuaranteeProgramTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(AuthenticityGuaranteeProgram::class)]
#[CoversClass(AuthenticityGuaranteeProgramTransformer::class)]
final class AuthenticityGuaranteeProgramTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            AuthenticityGuaranteeProgramTransformerInterface::KEY_DESCRIPTION => 'v_1',
            AuthenticityGuaranteeProgramTransformerInterface::KEY_TERMS_WEB_URL => 'v_2',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getDescription());
        self::assertSame('v_2', $actual->getTermsWebUrl());
    }

    /**
     * @param array<string, mixed>                                 $data
     * @param Closure(AuthenticityGuaranteeProgramInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(AuthenticityGuaranteeProgramInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (AuthenticityGuaranteeProgramInterface $model): void {
                self::assertNull($model->getDescription());
                self::assertNull($model->getTermsWebUrl());
            },
        ];

        yield 'descriptionWrongType' => [
            [...$base, AuthenticityGuaranteeProgramTransformerInterface::KEY_DESCRIPTION => 42],
            static function (AuthenticityGuaranteeProgramInterface $model): void {
                self::assertNull($model->getDescription());
            },
        ];

        yield 'termsWebUrlWrongType' => [
            [...$base, AuthenticityGuaranteeProgramTransformerInterface::KEY_TERMS_WEB_URL => 42],
            static function (AuthenticityGuaranteeProgramInterface $model): void {
                self::assertNull($model->getTermsWebUrl());
            },
        ];
    }

    private function buildTransformer(): AuthenticityGuaranteeProgramTransformer
    {

        return new AuthenticityGuaranteeProgramTransformer();
    }
}

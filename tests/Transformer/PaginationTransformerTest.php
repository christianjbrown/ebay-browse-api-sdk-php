<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Tests\Transformer;

use ChristianBrown\eBay\FindServiceApi\Model\Pagination;
use ChristianBrown\eBay\FindServiceApi\Transformer\PaginationTransformer;
use ChristianBrown\eBay\FindServiceApi\Transformer\PaginationTransformerInterface;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function array_merge;
use function sprintf;

#[CoversClass(Pagination::class)]
#[CoversClass(PaginationTransformer::class)]
final class PaginationTransformerTest extends TestCase
{
    public static function dataProviderForTransformInvalid(): array
    {
        $testCases = [];
        $data = [
            PaginationTransformerInterface::DATA_KEY_PAGINATION_ENTRIES_PER_PAGE => [25],
            PaginationTransformerInterface::DATA_KEY_PAGINATION_PAGE_NUMBER => [3],
            PaginationTransformerInterface::DATA_KEY_PAGINATION_ENTRIES_TOTAL_ENTRIES => [42],
            PaginationTransformerInterface::DATA_KEY_PAGINATION_ENTRIES_TOTAL_PAGES => [10],
        ];

        foreach (PaginationTransformerInterface::DATA_KEYS as $key) {
            $testCaseMissingData = $data;
            unset($testCaseMissingData[$key]);
            $testCaseMissing = [
                $testCaseMissingData,
                sprintf('Pagination %s is missing', $key),
            ];
            $testCases[] = $testCaseMissing;

            $testCaseIsNotAnArray = [
                array_merge($data, [$key => 5]),
                sprintf('Pagination %s is not an array', $key),
            ];
            $testCases[] = $testCaseIsNotAnArray;

            $testCaseArrayNotSize1 = [
                array_merge($data, [$key => [5, 6]]),
                sprintf('Pagination %s array does not have exactly one value', $key),
            ];
            $testCases[] = $testCaseArrayNotSize1;

            $testCaseArrayNotAtIndex0 = [
                array_merge($data, [$key => ['key' => 5]]),
                sprintf('Pagination %s array value is not available at 0-index', $key),
            ];
            $testCases[] = $testCaseArrayNotAtIndex0;

            $testCaseArrayNotNumeric = [
                array_merge($data, [$key => ['test']]),
                sprintf('Pagination %s array value is not numeric', $key),
            ];
            $testCases[] = $testCaseArrayNotNumeric;
        }

        return $testCases;
    }

    public function testTransform(): void
    {
        $data = [
            PaginationTransformerInterface::DATA_KEY_PAGINATION_ENTRIES_PER_PAGE => [25.0],
            PaginationTransformerInterface::DATA_KEY_PAGINATION_PAGE_NUMBER => [3.1],
            PaginationTransformerInterface::DATA_KEY_PAGINATION_ENTRIES_TOTAL_ENTRIES => [42.2],
            PaginationTransformerInterface::DATA_KEY_PAGINATION_ENTRIES_TOTAL_PAGES => [10.4],
        ];
        $transformer = new PaginationTransformer();
        $actual = $transformer->transform($data);
        self::assertSame(25, $actual->getEntriesPerPage());
        self::assertSame(3, $actual->getPageNumber());
        self::assertSame(42, $actual->getTotalEntries());
        self::assertSame(10, $actual->getTotalPages());
    }

    #[DataProvider('dataProviderForTransformInvalid')]
    public function testTransformInvalid(array $data, string $expectedExceptionMessage): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $transformer = new PaginationTransformer();
        $actual = $transformer->transform($data);
        self::assertSame(25, $actual->getEntriesPerPage());
        self::assertSame(3, $actual->getPageNumber());
        self::assertSame(42, $actual->getTotalEntries());
        self::assertSame(10, $actual->getTotalPages());
    }
}

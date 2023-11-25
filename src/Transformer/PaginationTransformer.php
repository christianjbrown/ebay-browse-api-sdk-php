<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Transformer;

use ChristianBrown\eBay\FindServiceApi\Model\Pagination;
use ChristianBrown\eBay\FindServiceApi\Model\PaginationInterface;
use InvalidArgumentException;

use function count;
use function is_array;
use function is_numeric;
use function sprintf;

final class PaginationTransformer implements PaginationTransformerInterface
{
    public function transform(array $data): PaginationInterface
    {
        foreach (self::DATA_KEYS as $key) {
            if (!isset($data[$key])) {
                throw new InvalidArgumentException(sprintf('Pagination %s is missing', $key));
            }
            if (!is_array($data[$key])) {
                throw new InvalidArgumentException(sprintf('Pagination %s is not an array', $key));
            }
            if (1 !== count($data[$key])) {
                throw new InvalidArgumentException(sprintf('Pagination %s array does not have exactly one value', $key));
            }
            if (!isset($data[$key][0])) {
                throw new InvalidArgumentException(sprintf('Pagination %s array value is not available at 0-index', $key));
            }
            if (!is_numeric($data[$key][0])) {
                throw new InvalidArgumentException(sprintf('Pagination %s array value is not numeric', $key));
            }
        }
        $totalEntries = (int) $data[self::DATA_KEY_PAGINATION_ENTRIES_TOTAL_ENTRIES][0];
        $pageNumber = (int) $data[self::DATA_KEY_PAGINATION_PAGE_NUMBER][0];
        $perPage = (int) $data[self::DATA_KEY_PAGINATION_ENTRIES_PER_PAGE][0];
        $totalPages = (int) $data[self::DATA_KEY_PAGINATION_ENTRIES_TOTAL_PAGES][0];

        $pagination = new Pagination($totalEntries, $pageNumber, $perPage, $totalPages);

        return $pagination;
    }
}

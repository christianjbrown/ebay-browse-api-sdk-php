<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\AspectInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class AspectsTransformer implements AspectsTransformerInterface
{
    private AspectTransformerInterface $aspectTransformer;

    public function __construct(AspectTransformerInterface $aspectTransformer)
    {
        $this->aspectTransformer = $aspectTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, AspectInterface>
     */
    public function transform(array $data): array
    {
        $aspects = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $aspectData = $values[$i];
            if (!is_array($aspectData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $aspects[] = $this->aspectTransformer->transform($aspectData);
        }

        return $aspects;
    }
}

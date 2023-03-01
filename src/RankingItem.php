<?php

declare(strict_types=1);

namespace Jomisacu\RankingGenerator;

use Jomisacu\RankingGenerator\Contracts\RankableItemInterface;

final class RankingItem implements RankableItemInterface
{
    use RankableItemTrait;

    private float $valueUsedToComputeRating;
    private string $nameToIdentifyTheItem;
    private ?Rating $alreadyComputedRating;
    private ?float $maxPossibleValueToComputeTheRating;

    public function __construct(
        float $valueUsedToComputeRating,
        string $nameToIdentifyTheItem,
        ?Rating $alreadyComputedRating = null,
        float $maxPossibleValueToComputeTheRating = null
    ) {
        $this->valueUsedToComputeRating = $valueUsedToComputeRating;
        $this->nameToIdentifyTheItem = $nameToIdentifyTheItem;
        $this->alreadyComputedRating = $alreadyComputedRating;
        $this->maxPossibleValueToComputeTheRating = $maxPossibleValueToComputeTheRating;
    }

    public function getValue()
    {
        return $this->valueUsedToComputeRating;
    }

    protected function getUniqueDomainIdentifier(): string
    {
        return $this->nameToIdentifyTheItem;
    }

    protected function computeRating(): Rating
    {
        if (null != $this->alreadyComputedRating) {
            return $this->alreadyComputedRating;
        }

        if (null == $this->maxPossibleValueToComputeTheRating) {
            throw new \RuntimeException(sprintf('If not alreadyComputedRating provided you must to provide a maxPossibleValueToComputeTheRating in %s class constructor', __CLASS__));
        }

        return new Rating($this->getValue() * 100 / $this->maxPossibleValueToComputeTheRating);
    }
}

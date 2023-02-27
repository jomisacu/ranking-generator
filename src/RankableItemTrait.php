<?php

declare(strict_types=1);

namespace Jomisacu\RankingGenerator;

use Symfony\Component\Uid\Uuid;

trait RankableItemTrait
{
    protected Rating $manualRating;
    protected Rating $rating;

    public function getId(): string
    {
        return Uuid::v5(
            new Uuid($this->getRankableItemsNamespace()),
            $this->getUniqueDomainIdentifier()
        )->toRfc4122();
    }

    private function getRankableItemsNamespace(): string
    {
        return "9eda4289-c3f2-4127-8859-ebe6e917bb9b";
    }

    abstract protected function getUniqueDomainIdentifier(): string;

    public function getRating(): Rating
    {
        return $this->manualRating ?? $this->rating ?? $this->rating = $this->computeRating();
    }

    abstract protected function computeRating(): float;

    public function setManualRating(Rating $rating): void
    {
        $this->manualRating = $rating;
    }
}

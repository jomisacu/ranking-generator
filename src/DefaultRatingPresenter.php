<?php

declare(strict_types=1);

namespace Jomisacu\RankingGenerator;

final class DefaultRatingPresenter implements Contracts\RatingPresenterInterface
{
    public function getRatingValue(Rating $rating, int $base, bool $lessIsBetter = false): float
    {
        $ratingValue = $rating->value();

        return $this->calculateRating($ratingValue, $base, $lessIsBetter);
    }

    private function calculateRating(float $ratingValue, int $base, bool $lessIsBetter = false)
    {
        if ($lessIsBetter) {
            $ratingValue -= (Rating::RATING_MAX_VALUE + 1);
        }

        return abs($ratingValue) / Rating::RATING_MAX_VALUE * $base;
    }
}

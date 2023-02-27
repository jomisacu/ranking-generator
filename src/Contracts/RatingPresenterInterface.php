<?php

declare(strict_types=1);

namespace Jomisacu\RankingGenerator\Contracts;

use Jomisacu\RankingGenerator\Rating;

interface RatingPresenterInterface
{
    public function getRatingValue(Rating $rating, int $base, bool $lessIsBetter = false): float;
}

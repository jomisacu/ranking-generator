<?php

declare(strict_types=1);

namespace Jomisacu\RankingGenerator;

use Jomisacu\RankingGenerator\Exceptions\RatingValueOutOfRangeException;

final class Rating
{
    private float $value;

    public function __construct(float $value)
    {
        $this->validate($value);

        $this->value = $value;
    }

    public function value(): float
    {
        return $this->value;
    }

    private function validate(float $value): void
    {
        if ($value < 1 || $value > 100) {
            throw new RatingValueOutOfRangeException();
        }
    }
}

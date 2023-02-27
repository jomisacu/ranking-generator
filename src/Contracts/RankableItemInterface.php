<?php

declare(strict_types=1);

namespace Jomisacu\RankingGenerator\Contracts;

use Jomisacu\RankingGenerator\Rating;

interface RankableItemInterface
{
    public function getId(): string;

    /**
     * The value to derive the rating
     *
     * @return mixed
     */
    public function getValue();

    public function getRating(): Rating;

    public function setManualRating(Rating $rating): void;
}

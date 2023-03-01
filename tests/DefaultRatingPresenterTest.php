<?php

declare(strict_types=1);

namespace Jomisacu\RankingGeneratorTests;

use Jomisacu\RankingGenerator\DefaultRatingPresenter;
use Jomisacu\RankingGenerator\Rating;
use PHPUnit\Framework\TestCase;

/**
 * Class DefaultRatingPresenterTest
 *
 * @package Jomisacu\RankingGeneratorTests
 *
 * @covers \Jomisacu\RankingGenerator\DefaultRatingPresenter
 */
class DefaultRatingPresenterTest extends TestCase
{
    public function testBase10RankingIsPresentedProperly()
    {
        $base = 10;
        $presenter = new DefaultRatingPresenter();

        $generated = [];
        foreach (range(1, Rating::RATING_MAX_VALUE) as $number) {
            $generated[] = $presenter->getRatingValue(new Rating($number), $base);
        }

        $generatedWithLessIsBetter = [];
        foreach (range(Rating::RATING_MAX_VALUE, 1) as $number) {
            $generatedWithLessIsBetter[] = $presenter->getRatingValue(new Rating($number), $base, true);
        }

        $this->assertEquals($generated, $generatedWithLessIsBetter);
    }
}

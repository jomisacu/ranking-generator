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
        foreach (range(1, 100) as $number) {
            $generated[] = $presenter->getRatingValue(new Rating($number), $base);
        }

        $generatedWithLessIsBetter = [];
        foreach (range(100, 1) as $number) {
            $generatedWithLessIsBetter[] = $presenter->getRatingValue(new Rating($number), $base, true);
        }

        $this->assertEquals($generated, $generatedWithLessIsBetter);
    }
}

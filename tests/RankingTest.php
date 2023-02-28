<?php

declare(strict_types=1);

namespace Jomisacu\RankingGeneratorTests;

use Jomisacu\RankingGenerator\Contracts\RankableItemInterface;
use Jomisacu\RankingGenerator\Contracts\RankingGeneratorInterface;
use Jomisacu\RankingGenerator\Ranking;
use Jomisacu\RankingGeneratorTests\Stubs\RankableSmartTv;
use PHPUnit\Framework\TestCase;

/**
 * Class RankingTest
 *
 * @package Jomisacu\RankingGeneratorTests
 *
 * @covers \Jomisacu\RankingGenerator\Ranking
 */
class RankingTest extends TestCase implements RankingGeneratorInterface
{
    private array $items = [
        [
            'size' => 40,
            'name' => 'Tv sony Bravia 40"',
        ],
        [
            'size' => 50,
            'name' => 'Tv samsung 50"',
        ],
        [
            'size' => 70,
            'name' => 'Tv samsung 70"',
        ],
    ];

    public function testRankingInstanceCreatedSuccessfully()
    {
        $ranking = $this->getRankingInstance();

        $this->assertInstanceOf(Ranking::class, $ranking);
    }

    public function testSetPositionWorksProperly()
    {
        $ranking = $this->getRankingInstance();
        $rankableItem = $ranking->getItems()[2];
        $ranking->setPosition($rankableItem, 0);

        $this->assertTrue($rankableItem->getId() === $ranking->getItems()[0]->getId(), 'The rankable item is not in the given position');
    }

    private function buildRankingItem(int $displaySizeInInches, string $model): RankableItemInterface
    {
        return new RankableSmartTv($displaySizeInInches, $model);
    }

    public function build(array $items): array
    {
        $rankableItems = [];
        foreach ($items as $item) {
            $rankableItems[] = $this->buildRankingItem($item['size'], $item['name']);
        }

        return $rankableItems;
    }

    private function getRankingInstance(): Ranking
    {
        $rankingId = "a3ad2497-dea6-4acb-8711-c20365d87d29";

        return new Ranking($rankingId, 'Best smart TVs', ...$this->build($this->items));
    }
}

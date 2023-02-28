<?php

declare(strict_types=1);

namespace Jomisacu\RankingGenerator;

use Jomisacu\RankingGenerator\Contracts\RankableItemInterface;
use Jomisacu\RankingGenerator\Exceptions\ItemNotFoundInRankingException;

final class Ranking
{
    private string $id;
    private string $name;

    /**
     * @var RankableItemInterface[]
     */
    private array $items;

    public function __construct(string $id, string $name, RankableItemInterface ...$items)
    {
        $this->id = $id;
        $this->name = $name;
        $this->items = $items;

        $this->sort();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setPosition(RankableItemInterface $rankableItem, int $position): void
    {
        $this->removeRankableItem($rankableItem);
        $this->putRankableItem($position, $rankableItem);

        $previousItem = $this->getItemByPosition($position - 1);
        $nextItem = $this->getItemByPosition($position + 1);

        $newRating = 0;
        if ($previousItem && $nextItem) {
            $newRating = ($previousItem->getRating()->value() + $nextItem->getRating()->value()) / 2;
        } elseif ($previousItem) {
            $newRating = $previousItem->getRating()->value() - 0.01;
        } elseif ($nextItem) {
            $newRating = $nextItem->getRating()->value() + 0.01;
        }

        $rankableItem->setManualRating(new Rating($newRating));
    }

    private function removeRankableItem(RankableItemInterface $rankableItem): void
    {
        $this->items = array_filter(
            $this->items,
            fn (RankableItemInterface $item) => $item->getId() != $rankableItem->getId()
        );
    }

    private function putRankableItem(int $position, RankableItemInterface $rankableItem): void
    {
        array_splice($this->items, $position, 0, [$rankableItem]);
    }

    private function getItemByPosition(int $position): ?RankableItemInterface
    {
        return $this->items[$position] ?? null;
    }

    private function getPosition(RankableItemInterface $rankableItem): int
    {
        foreach (array_values($this->getItems()) as $position => $item) {
            if ($item->getId() == $rankableItem->getId()) {
                return $position;
            }
        }

        throw new ItemNotFoundInRankingException();
    }

    public function getItems(): array
    {
        return $this->items;
    }

    private function sort(): void
    {
        usort($this->items, function (RankableItemInterface $rankableItem1, RankableItemInterface $rankableItem2) {
            if ($rankableItem1->getRating() > $rankableItem2->getRating()) {
                return -1;
            }

            if ($rankableItem2->getRating() > $rankableItem1->getRating()) {
                return 1;
            }

            return 0;
        });
    }
}

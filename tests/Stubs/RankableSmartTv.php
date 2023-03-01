<?php

declare(strict_types=1);

namespace Jomisacu\RankingGeneratorTests\Stubs;

use Jomisacu\RankingGenerator\RankableItemTrait;
use Jomisacu\RankingGenerator\Rating;

final class RankableSmartTv implements \Jomisacu\RankingGenerator\Contracts\RankableItemInterface
{
    use RankableItemTrait;

    const MAX_DISPLAY_SIZE_IN_INCHES = 85;

    public static array $instances = [];
    private string $id;
    private int $displaySizeInInches;
    private string $model;

    public function __construct(int $displaySizeInInches, string $model)
    {
        self::$instances[] = $this;

        $this->id = 'ranking_item_' . count(self::$instances);
        $this->displaySizeInInches = $displaySizeInInches;
        $this->model = $model;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return $this->displaySizeInInches;
    }

    protected function getUniqueDomainIdentifier(): string
    {
        return $this->model;
    }

    protected function computeRating(): Rating
    {
        return new Rating($this->displaySizeInInches * 100 / self::MAX_DISPLAY_SIZE_IN_INCHES);
    }
}
